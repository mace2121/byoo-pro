<footer class="border-t border-white/10 bg-slate-950/80 pb-10 pt-8">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex flex-col gap-3">
            <a href="#hero" class="inline-flex items-center">
                <x-brand-mark
                    class="text-white"
                    icon-class="h-8 w-8 text-white"
                    text-class="text-lg font-semibold tracking-tight text-white"
                    dot-class="text-cyan-300"
                />
            </a>
            <p class="max-w-md text-sm leading-7 text-slate-400">
                Link, urun ve siparis akisini tek sayfada birlestiren modern bio site builder.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-5 text-sm text-slate-400">
            <a href="#problem" class="transition hover:text-white">Neden byoo?</a>
            <a href="#builder" class="transition hover:text-white">Builder</a>
            <a href="#customize" class="transition hover:text-white">Temalar</a>
            <a href="#proof" class="transition hover:text-white">Guven</a>
            <a href="#faq" class="transition hover:text-white">SSS</a>
        </div>
    </div>

    <div class="mx-auto mt-8 flex max-w-7xl flex-col gap-4 border-t border-white/10 px-4 pt-6 text-sm text-slate-500 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <p>&copy; {{ date('Y') }} byoo.pro. Tum haklari saklidir.</p>
        <div class="flex items-center gap-3 text-slate-400">
            <x-application-logo class="h-4 w-4 text-white/80" />
            <span>Creators, store owners ve dijital markalar icin tasarlandi.</span>
        </div>
    </div>
</footer>
