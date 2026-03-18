<nav
    :class="navSolid ? 'bg-slate-950/82 border-white/10 shadow-[0_18px_50px_rgba(2,6,23,0.32)]' : 'bg-transparent border-transparent'"
    class="fixed inset-x-0 top-0 z-50 border-b backdrop-blur-xl transition-all duration-300"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="#hero" class="flex items-center gap-3">
            <x-brand-mark
                class="text-white"
                icon-class="h-9 w-9 text-white"
                text-class="text-xl font-semibold tracking-tight text-white"
                dot-class="text-cyan-300"
            />
        </a>

        <div class="hidden items-center gap-7 lg:flex">
            <a href="#problem" :class="navLinkClass('problem')" class="text-sm font-medium transition-colors">Neden byoo?</a>
            <a href="#builder" :class="navLinkClass('builder')" class="text-sm font-medium transition-colors">Builder</a>
            <a href="#products" :class="navLinkClass('products')" class="text-sm font-medium transition-colors">Urunler</a>
            <a href="#customize" :class="navLinkClass('customize')" class="text-sm font-medium transition-colors">Temalar</a>
            <a href="#proof" :class="navLinkClass('proof')" class="text-sm font-medium transition-colors">Guven</a>
            <a href="#faq" :class="navLinkClass('faq')" class="text-sm font-medium transition-colors">SSS</a>
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="ghost-button inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold text-slate-100 transition hover:bg-white/5">
                        Panele git
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-slate-300 transition hover:text-white">
                        Giris yap
                    </a>
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="glow-button inline-flex items-center gap-2 rounded-full bg-[#00ffcc] px-5 py-2.5 text-sm font-bold text-slate-950 transition hover:translate-y-[-1px] hover:bg-[#7effe1]"
                        >
                            <span class="h-2 w-2 rounded-full bg-slate-950"></span>
                            Ucretsiz basla
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-white/5 text-slate-100 lg:hidden"
            type="button"
        >
            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

    <div
        x-show="mobileMenuOpen"
        x-cloak
        x-transition.opacity
        class="border-t border-white/10 bg-slate-950/96 px-4 pb-6 pt-4 backdrop-blur-xl lg:hidden"
    >
        <div class="flex flex-col gap-2">
            <a @click="mobileMenuOpen = false" href="#problem" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">Neden byoo?</a>
            <a @click="mobileMenuOpen = false" href="#builder" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">Builder</a>
            <a @click="mobileMenuOpen = false" href="#products" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">Urunler</a>
            <a @click="mobileMenuOpen = false" href="#customize" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">Temalar</a>
            <a @click="mobileMenuOpen = false" href="#proof" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">Guven</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/5">SSS</a>
        </div>

        @if (Route::has('login'))
            <div class="mt-4 grid gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="ghost-button rounded-2xl px-4 py-3 text-center text-sm font-semibold text-white">
                        Panele git
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-2xl px-4 py-3 text-center text-sm font-medium text-slate-200">
                        Giris yap
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="glow-button rounded-2xl bg-[#00ffcc] px-4 py-3 text-center text-sm font-bold text-slate-950">
                            Ucretsiz basla
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</nav>
