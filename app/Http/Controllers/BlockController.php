<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Link;
use App\Services\BlockService;
use App\Services\LinkPreviewService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BlockController extends Controller
{
    public function __construct(
        protected ProfileService $profileService,
        protected BlockService $blockService,
        protected LinkPreviewService $linkPreviewService,
    ) {
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $this->ensureBlocksReady();

        if ($this->userHasReachedBlockLimit($user)) {
            return redirect()->route('dashboard', ['tab' => 'links'])
                ->with('error', 'Blok limitinize ulastiniz. Daha fazla blok eklemek icin planinizi yukseltebilirsiniz.');
        }

        $validated = $this->validateBlock($request);

        if (! auth()->user()->canUseScheduling()) {
            $validated['starts_at'] = null;
            $validated['expires_at'] = null;
        }

        if (($validated['type'] ?? null) === 'product' && ! $user->canUseProductBlocks()) {
            return redirect()
                ->route('dashboard', ['tab' => 'links'])
                ->with('error', 'Ürün blokları yalnızca Pro pakette kullanılabilir.');
        }

        $previewUrl = null;

        DB::transaction(function () use ($request, $user, $validated, &$previewUrl) {
            $position = ((int) $user->blocks()->max('position')) + 1;

            if ($validated['type'] === 'link') {
                $previewUrl = $validated['url'];
                $link = $user->links()->create([
                    'title' => $validated['title'],
                    'url' => $validated['url'],
                    'icon' => $validated['icon'] ?: null,
                    'order' => $position,
                    'is_active' => (bool) ($validated['is_active'] ?? true),
                    'starts_at' => $validated['starts_at'] ?? null,
                    'expires_at' => $validated['expires_at'] ?? null,
                ]);

                $user->blocks()->create([
                    'source_link_id' => $link->id,
                    'type' => 'link',
                    'title' => $validated['title'],
                    'url' => $validated['url'],
                    'button_type' => 'external_link',
                    'button_link' => $validated['url'],
                    'position' => $position,
                    'is_active' => (bool) ($validated['is_active'] ?? true),
                    'starts_at' => $validated['starts_at'] ?? null,
                    'expires_at' => $validated['expires_at'] ?? null,
                    'data' => [
                        'icon' => $validated['icon'] ?: null,
                        'display_mode' => $validated['display_mode'] ?? 'link',
                    ],
                ]);

                return;
            }

            $productImage = $this->resolveProductImage($request, $validated);

            $user->blocks()->create([
                'type' => 'product',
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image' => $productImage,
                'url' => $validated['url'] ?? null,
                'button_type' => $validated['button_type'] ?? 'external_link',
                'button_link' => $validated['button_link'] ?? null,
                'position' => $position,
                'is_active' => (bool) ($validated['is_active'] ?? true),
                'starts_at' => $validated['starts_at'] ?? null,
                'expires_at' => $validated['expires_at'] ?? null,
                'data' => [
                    'icon' => $validated['icon'] ?: null,
                    'price' => $validated['price'] ?? null,
                    'button_label' => $validated['button_label'] ?? null,
                    'whatsapp_message' => $validated['whatsapp_message'] ?? null,
                ],
            ]);
        });

        $this->refreshPreview($previewUrl);
        $this->profileService->clearProfileCache($user);

        return redirect()->route('dashboard', ['tab' => 'links'])->with('success', 'Blok eklendi.');
    }

    public function update(Request $request, Block $block)
    {
        $user = Auth::user();
        $this->authorizeBlock($block, $user->id);
        $validated = $this->validateBlock($request);

        if (! auth()->user()->canUseScheduling()) {
            $validated['starts_at'] = null;
            $validated['expires_at'] = null;
        }

        if (($validated['type'] ?? null) === 'product' && ! $user->canUseProductBlocks()) {
            return redirect()
                ->route('dashboard', ['tab' => 'links'])
                ->with('error', 'Ürün blokları yalnızca Pro pakette kullanılabilir.');
        }

        $previewUrl = null;

        DB::transaction(function () use ($request, $block, $validated, &$previewUrl) {
            $existingImage = $block->image;
            $nextImage = null;

            if ($validated['type'] === 'product') {
                $nextImage = $this->resolveProductImage($request, $validated, $block);
            } elseif ($existingImage) {
                $this->deleteStoredProductImage($existingImage);
            }

            $block->type = $validated['type'];
            $block->title = $validated['title'];
            $block->description = $validated['type'] === 'product' ? ($validated['description'] ?? null) : null;
            $block->image = $validated['type'] === 'product' ? $nextImage : null;
            $block->url = $validated['type'] === 'link'
                ? $validated['url']
                : ($validated['url'] ?? null);
            $block->button_type = $validated['type'] === 'product'
                ? ($validated['button_type'] ?? 'external_link')
                : 'external_link';
            $block->button_link = $validated['type'] === 'product'
                ? ($validated['button_link'] ?? null)
                : $validated['url'];
            $block->is_active = (bool) ($validated['is_active'] ?? $block->is_active);
            $block->starts_at = $validated['starts_at'] ?? null;
            $block->expires_at = $validated['expires_at'] ?? null;
            $block->data = array_filter([
                'icon' => $validated['icon'] ?: null,
                'display_mode' => $validated['type'] === 'link'
                    ? ($validated['display_mode'] ?? 'link')
                    : ($validated['display_mode'] ?? 'card'),
                'price' => $validated['type'] === 'product' ? ($validated['price'] ?? null) : null,
                'button_label' => $validated['type'] === 'product' ? ($validated['button_label'] ?? null) : null,
                'whatsapp_message' => $validated['type'] === 'product' ? ($validated['whatsapp_message'] ?? null) : null,
            ], static fn ($value) => $value !== null && $value !== '');
            $block->save();

            if ($block->type === 'link') {
                $previewUrl = $validated['url'];
                $link = $block->sourceLink ?: new Link([
                    'user_id' => $block->user_id,
                    'order' => $block->position,
                ]);

                $link->user_id = $block->user_id;
                $link->title = $validated['title'];
                $link->url = $validated['url'];
                $link->icon = $validated['icon'] ?: null;
                $link->order = $block->position;
                $link->is_active = $block->is_active;
                $link->starts_at = $block->starts_at;
                $link->expires_at = $block->expires_at;
                $link->save();

                if (! $block->source_link_id) {
                    $block->source_link_id = $link->id;
                    $block->save();
                }
            } elseif ($block->sourceLink) {
                $block->sourceLink->delete();
                $block->source_link_id = null;
                $block->save();
            }
        });

        $this->refreshPreview($previewUrl);
        $this->profileService->clearProfileCache($user);

        return redirect()->route('dashboard', ['tab' => 'links'])->with('success', 'Blok guncellendi.');
    }

    public function toggle(Block $block)
    {
        $user = Auth::user();
        $this->authorizeBlock($block, $user->id);

        $nextState = ! $block->is_active;
        $block->update(['is_active' => $nextState]);

        if ($block->sourceLink) {
            $block->sourceLink->update(['is_active' => $nextState]);
        }

        $this->profileService->clearProfileCache($user);

        return response()->json(['success' => true, 'is_active' => $nextState]);
    }

    public function destroy(Block $block)
    {
        $user = Auth::user();
        $this->authorizeBlock($block, $user->id);

        DB::transaction(function () use ($block, $user) {
            if ($block->image) {
                $this->deleteStoredProductImage($block->image);
            }

            if ($block->sourceLink) {
                $block->sourceLink->delete();
            }

            $block->delete();

            $remainingBlocks = $user->blocks()->with('sourceLink')->orderBy('position')->get();

            foreach ($remainingBlocks as $index => $remainingBlock) {
                if ($remainingBlock->position !== $index) {
                    $remainingBlock->update(['position' => $index]);
                }

                if ($remainingBlock->sourceLink && $remainingBlock->sourceLink->order !== $index) {
                    $remainingBlock->sourceLink->update(['order' => $index]);
                }
            }
        });

        $this->profileService->clearProfileCache($user);

        return redirect()->route('dashboard', ['tab' => 'links'])->with('success', 'Blok silindi.');
    }

    public function reorder(Request $request)
    {
        $user = Auth::user();
        $orderedIds = array_values(array_filter((array) $request->input('ordered_ids', [])));

        DB::transaction(function () use ($user, $orderedIds) {
            foreach ($orderedIds as $index => $id) {
                $block = $user->blocks()->with('sourceLink')->find($id);

                if (! $block) {
                    continue;
                }

                $block->update(['position' => $index]);

                if ($block->sourceLink) {
                    $block->sourceLink->update(['order' => $index]);
                }
            }
        });

        $this->profileService->clearProfileCache($user);

        return response()->json(['success' => true]);
    }

    public function refreshPreviews()
    {
        $user = Auth::user();

        if (! $this->linkPreviewService->tableExists()) {
            return redirect()->route('dashboard', ['tab' => 'links'])
                ->with('error', 'Link preview tablosu hazir degil. Lutfen migration calistirin.');
        }

        $urls = $user->links()
            ->whereNotNull('url')
            ->pluck('url')
            ->filter()
            ->unique()
            ->values();

        $refreshed = 0;

        foreach ($urls as $url) {
            try {
                $this->linkPreviewService->refresh($url, true);
                $refreshed++;
            } catch (\Throwable) {
                // Continue refreshing remaining links.
            }
        }

        return redirect()->route('dashboard', ['tab' => 'links'])
            ->with('success', "{$refreshed} link preview kaydi yenilendi.");
    }

    protected function validateBlock(Request $request): array
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['link', 'product'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'url' => ['nullable', 'url', 'max:2048'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_mode' => ['nullable', Rule::in(['link', 'card'])],
            'price' => ['nullable', 'string', 'max:120'],
            'button_type' => ['nullable', Rule::in(['external_link', 'whatsapp'])],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'button_label' => ['nullable', 'string', 'max:120'],
            'whatsapp_message' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        if ($validated['type'] === 'link') {
            $request->validate([
                'url' => ['required', 'url', 'max:2048'],
            ]);
        }

        if ($validated['type'] === 'product' && ($validated['button_type'] ?? 'external_link') === 'external_link') {
            $request->validate([
                'button_link' => ['required', 'url', 'max:2048'],
            ]);
        }

        if ($validated['type'] === 'product' && ($validated['button_type'] ?? null) === 'whatsapp') {
            $request->validate([
                'button_link' => ['required', 'string', 'max:2048'],
            ]);
        }

        return $validated;
    }

    protected function authorizeBlock(Block $block, int $userId): void
    {
        abort_unless($block->user_id === $userId, 404);
    }

    protected function ensureBlocksReady(): void
    {
        abort_unless($this->blockService->blocksTableExists(), 503, 'Blocks tablosu hazir degil. Lutfen migration calistirin.');
    }

    protected function userHasReachedBlockLimit($user): bool
    {
        $plan = $user->activePlan();
        $limit = $plan?->link_limit ?? 5;

        if ((int) $limit <= 0) {
            return false;
        }

        return $user->blocks()->count() >= $limit;
    }

    protected function refreshPreview(?string $url): void
    {
        if (! $url) {
            return;
        }

        try {
            $this->linkPreviewService->refresh($url, true);
        } catch (\Throwable) {
            // Preview fetching should not block block creation or updates.
        }
    }

    protected function resolveProductImage(Request $request, array $validated, ?Block $block = null): ?string
    {
        $currentImage = $block?->image;
        $removeImage = $request->boolean('remove_image');

        if ($request->hasFile('image_file')) {
            $storedImage = $this->storeProductImage($request->file('image_file'));

            if ($currentImage && $currentImage !== $storedImage) {
                $this->deleteStoredProductImage($currentImage);
            }

            return $storedImage;
        }

        $imageUrl = $validated['image_url'] ?? null;

        if (filled($imageUrl)) {
            if ($currentImage && $currentImage !== $imageUrl) {
                $this->deleteStoredProductImage($currentImage);
            }

            return $imageUrl;
        }

        if ($removeImage && $currentImage) {
            $this->deleteStoredProductImage($currentImage);

            return null;
        }

        return $currentImage;
    }

    protected function storeProductImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file);
        $image->scale(1600, null);
        $encoded = $image->toWebp(82);
        $filename = 'blocks/products/'.Str::random(40).'.webp';

        if (! Storage::disk('public')->exists('blocks/products')) {
            Storage::disk('public')->makeDirectory('blocks/products');
        }

        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }

    protected function deleteStoredProductImage(?string $imagePath): void
    {
        if (! $imagePath || filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return;
        }

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
