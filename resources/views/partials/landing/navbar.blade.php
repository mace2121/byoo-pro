<nav
    :class="navSolid ? 'border-white/10 bg-black/75 shadow-[0_20px_60px_rgba(0,0,0,0.45)]' : 'border-transparent bg-transparent'"
    class="fixed inset-x-0 top-0 z-50 border-b backdrop-blur-xl transition-all duration-300"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="#hero" class="inline-flex items-center">
            <x-brand-mark
                class="text-white"
                icon-class="h-9 w-9 text-white"
                text-class="text-xl font-semibold tracking-tight text-white"
                dot-class="text-[color:var(--landing-accent)]"
            />
        </a>

        <div class="hidden items-center gap-7 lg:flex">
            <a href="#showcase" class="text-sm font-medium text-zinc-300 transition hover:text-white">Deneyim</a>
            <a href="#features" class="text-sm font-medium text-zinc-300 transition hover:text-white">Özellikler</a>
            <a href="#plans" class="text-sm font-medium text-zinc-300 transition hover:text-white">Paketler</a>
            <a href="#faq" class="text-sm font-medium text-zinc-300 transition hover:text-white">SSS</a>
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="premium-button-ghost inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold transition">
                        Panele Git
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-zinc-300 transition hover:text-white">
                        Giriş Yap
                    </a>
                    <a
                        href="{{ Route::has('register') ? route('register') : route('login') }}"
                        class="premium-button inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-bold transition"
                    >
                        <i class="fa-solid fa-star"></i>
                        Hemen Başla
                    </a>
                @endauth
            @endif
        </div>

        <button
            type="button"
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white lg:hidden"
        >
            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

    <div
        x-show="mobileMenuOpen"
        x-cloak
        x-transition.opacity
        class="border-t border-white/10 bg-black/90 px-4 pb-6 pt-4 backdrop-blur-xl lg:hidden"
    >
        <div class="flex flex-col gap-2">
            <a @click="mobileMenuOpen = false" href="#showcase" class="rounded-2xl px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-white/5">Deneyim</a>
            <a @click="mobileMenuOpen = false" href="#features" class="rounded-2xl px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-white/5">Özellikler</a>
            <a @click="mobileMenuOpen = false" href="#plans" class="rounded-2xl px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-white/5">Paketler</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="rounded-2xl px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-white/5">SSS</a>
        </div>

        @if (Route::has('login'))
            <div class="mt-4 grid gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="premium-button-ghost rounded-2xl px-4 py-3 text-center text-sm font-semibold text-white">
                        Panele Git
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-2xl px-4 py-3 text-center text-sm font-medium text-zinc-200">
                        Giriş Yap
                    </a>
                    <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="premium-button rounded-2xl px-4 py-3 text-center text-sm font-bold">
                        Hemen Başla
                    </a>
                @endauth
            </div>
        @endif
    </div>
</nav>
