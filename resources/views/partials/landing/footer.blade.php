<footer class="border-t border-white/10 bg-black/70 pb-10 pt-8">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex flex-col gap-3">
            <a href="#hero" class="inline-flex items-center">
                <x-brand-mark
                    class="text-white"
                    icon-class="h-8 w-8 text-white"
                    text-class="text-lg font-semibold tracking-tight text-white"
                    dot-class="text-[color:var(--landing-accent)]"
                />
            </a>
            <p class="max-w-md text-sm leading-7 text-zinc-400">
                Linklerini premium görünümlü tek bir vitrinde topla. Free ile başla, Pro ile markanı büyüt.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-5 text-sm text-zinc-400">
            <a href="#showcase" class="transition hover:text-white">Deneyim</a>
            <a href="#features" class="transition hover:text-white">Özellikler</a>
            <a href="#plans" class="transition hover:text-white">Paketler</a>
            <a href="#faq" class="transition hover:text-white">SSS</a>
        </div>
    </div>

    <div class="mx-auto mt-8 flex max-w-7xl flex-col gap-4 border-t border-white/10 px-4 pt-6 text-sm text-zinc-500 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <p>&copy; {{ date('Y') }} byoo.pro. Tüm hakları saklıdır.</p>
        <div class="flex items-center gap-3 text-zinc-400">
            <x-application-logo class="h-4 w-4 text-white/80" />
            <span>Premium görünüm isteyen creator'lar ve markalar için tasarlandı.</span>
        </div>
    </div>
</footer>
