@php
    $faqs = [
        [
            'question' => 'Free pakette neler yapabilirim?',
            'answer' => 'Free paket ile premium görünümlü bir başlangıç sayfası kurabilir, maksimum 5 link ekleyebilir ve profilini hızlıca yayına alabilirsin.',
        ],
        [
            'question' => 'Pro paket hangi özellikleri açıyor?',
            'answer' => 'Pro paket sınırsız link, ürün ekleme, custom tema & CSS, verified badge ve analytics özelliklerini açar.',
        ],
        [
            'question' => 'Ürün ekleme her kullanıcıya açık mı?',
            'answer' => 'Hayır. Ürün blokları ve satış odaklı vitrin alanları yalnızca Pro pakette aktif olur.',
        ],
        [
            'question' => 'Verified badge ve analytics neden önemli?',
            'answer' => 'Verified badge profilin daha profesyonel ve güvenilir görünmesini sağlar. Analytics ise hangi bağlantıların daha çok tıklandığını net şekilde görmene yardımcı olur.',
        ],
    ];
@endphp

<section id="faq" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <div class="premium-tag justify-center">
                <i class="fa-solid fa-circle-question"></i>
                Sık sorulanlar
            </div>
            <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                Paketleri seçmeden önce en çok sorulan sorular.
            </h2>
            <p class="mt-5 text-lg leading-8 text-zinc-300">
                byoo.pro deneyimini daha net görmek için temel soruları tek yerde topladık.
            </p>
        </div>

        <div class="mt-12 space-y-4">
            @foreach ($faqs as $index => $faq)
                <article class="rounded-[1.75rem] border p-1 transition" :class="faqClass({{ $index }})">
                    <button
                        type="button"
                        @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}"
                        class="flex w-full items-center justify-between gap-4 rounded-[1.4rem] px-5 py-5 text-left sm:px-6"
                    >
                        <span class="text-lg font-semibold text-white">{{ $faq['question'] }}</span>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-zinc-300">
                            <i class="fa-solid" :class="activeFaq === {{ $index }} ? 'fa-minus' : 'fa-plus'"></i>
                        </span>
                    </button>
                    <div x-show="activeFaq === {{ $index }}" x-transition.opacity.duration.300ms class="px-5 pb-6 sm:px-6">
                        <p class="text-sm leading-7 text-zinc-400">{{ $faq['answer'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
