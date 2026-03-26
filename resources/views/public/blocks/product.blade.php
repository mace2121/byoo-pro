@php
    $variantClass = '';
    if (($design['buttons']['variant'] ?? '') === 'offset') {
        $variantClass = 'variant-offset';
    } elseif (($design['buttons']['variant'] ?? '') === 'glass') {
        $variantClass = 'backdrop-blur-md variant-glass';
    }

    $blockData   = is_array($block->data) ? $block->data : json_decode((string) $block->data, true) ?: [];
    $isWhatsapp  = ($block->button_type ?? '') === 'whatsapp';
    $waPhone     = $block->button_link ?? env('WHATSAPP_UPGRADE_NUMBER', '');
    $waPhone     = preg_replace('/\D/', '', $waPhone); // sadece rakam
    $waMessage   = (is_array($blockData) ? ($blockData['whatsapp_message'] ?? null) : ($blockData->whatsapp_message ?? null)) ?? ('Merhaba, ' . $block->title . ' ürününü sipariş vermek istiyorum.');
    $waUrl       = "https://wa.me/{$waPhone}?text=" . rawurlencode($waMessage);
    $btnHref     = $isWhatsapp ? $waUrl : ($block->button_link ?? $block->url ?? '#');
    $btnLabel    = (is_array($blockData) ? ($blockData['button_label'] ?? null) : ($blockData->button_label ?? null)) ?: ($isWhatsapp ? 'WhatsApp ile Sipariş Ver' : 'Ürünü İncele');
@endphp

<div class="overflow-hidden transition-all duration-300 theme-card theme-card-stacked group relative {{ $variantClass }}">
    @if($block->image)
        <div class="aspect-[16/9] overflow-hidden border-b border-black/5">
            <img src="{{ $block->image }}" alt="{{ $block->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>
    @endif

    <div class="p-4 space-y-3">
        <div class="space-y-1 text-left">
            <div class="flex items-center gap-3">
                <div class="theme-card-icon-wrap flex h-10 w-10 items-center justify-center rounded-lg bg-black/5 dark:bg-white/5">
                    <i class="{{ $block->icon ?: 'fas fa-bag-shopping' }} theme-card-icon text-lg"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="truncate text-base font-bold">{{ $block->title }}</h3>
                    @php $price = is_array($blockData) ? ($blockData['price'] ?? null) : ($blockData->price ?? null); @endphp
                    @if(!empty($price))
                        <p class="text-sm font-semibold opacity-90">{{ $price }}</p>
                    @endif
                </div>
            </div>

            @if($block->description)
                <p class="text-sm opacity-80 leading-relaxed pt-1">{{ $block->description }}</p>
            @endif
        </div>

        <a href="{{ $btnHref }}"
           target="_blank"
           rel="noopener noreferrer"
           class="theme-card {{ $variantClass }} inline-flex w-full items-center justify-center gap-2 px-4 py-3 text-sm font-semibold transition-all hover:opacity-90">
            @if($isWhatsapp)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.062.524 4.003 1.447 5.7L0 24l6.474-1.425A11.935 11.935 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.79 9.79 0 0 1-5.033-1.388l-.36-.214-3.742.823.894-3.621-.235-.374A9.79 9.79 0 0 1 2.182 12C2.182 6.573 6.573 2.182 12 2.182S21.818 6.573 21.818 12 17.427 21.818 12 21.818z"/></svg>
            @endif
            {{ $btnLabel }}
        </a>
    </div>
</div>
