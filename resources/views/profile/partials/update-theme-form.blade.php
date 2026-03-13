<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Theme') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Profil sayfanız için bir tema seçin.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">

        @php
            $themes = [
                'minimal' => ['label' => 'Minimal', 'bg' => '#f9fafb', 'text' => '#111827', 'accent' => '#e5e7eb'],
                'dark' => ['label' => 'Dark', 'bg' => '#0f172a', 'text' => '#f1f5f9', 'accent' => '#334155'],
                'neon' => ['label' => 'Neon', 'bg' => '#0a0a0a', 'text' => '#39ff14', 'accent' => '#39ff14'],
                'glass' => ['label' => 'Glass', 'bg' => '#667eea', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.3)'],
                'midnight' => ['label' => 'Midnight', 'bg' => '#1a1a2e', 'text' => '#e0e0ff', 'accent' => '#0f3460'],
                'sunset' => ['label' => 'Sunset', 'bg' => '#f5576c', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.3)'],
                'aurora' => ['label' => 'Aurora', 'bg' => '#0c3547', 'text' => '#a7f3d0', 'accent' => '#34d399'],
                'forest' => ['label' => 'Forest', 'bg' => '#1a2f1a', 'text' => '#d4edda', 'accent' => '#5cb85c'],
                'cyber' => ['label' => 'Cyber', 'bg' => '#0d0221', 'text' => '#ff00ff', 'accent' => '#00ffff'],
                'obsidian' => ['label' => 'Obsidian', 'bg' => '#121212', 'text' => '#e0e0e0', 'accent' => '#333333'],
            ];
            $currentTheme = $user->profile?->theme ?? 'minimal';
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            @foreach($themes as $key => $theme)
                <label class="cursor-pointer">
                    <input type="radio" name="theme" value="{{ $key }}" class="sr-only peer" {{ $currentTheme === $key ? 'checked' : '' }}>
                    <div class="rounded-lg border-2 p-3 text-center transition-all peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-200 border-gray-200 dark:border-gray-600 hover:border-gray-300">
                        <div class="mx-auto w-full h-8 rounded-md mb-2 flex items-center justify-center" style="background-color: {{ $theme['bg'] }}; border: 1px solid {{ $theme['accent'] }};">
                            <span class="text-xs font-bold" style="color: {{ $theme['text'] }};">Aa</span>
                        </div>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $theme['label'] }}</span>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
