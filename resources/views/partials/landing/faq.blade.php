@php
    $faqs = [
        [
            'question' => 'byoo.pro gercekten ucretsiz baslanabilir mi?',
            'answer' => 'Evet. Temel profil, blok ekleme ve canli tema deneyimi ile hemen baslayabilirsin. Daha sonra ihtiyaca gore gelistirebilirsin.',
        ],
        [
            'question' => 'Landing icindeki builder demo gercek urunu ne kadar yansitiyor?',
            'answer' => 'Bu demo gercek urunun mantigini birebir hissettirmek icin kurgulandi. Blok mantigi, canli preview ve tema akisinin nasil calistigini net sekilde gosteriyor.',
        ],
        [
            'question' => 'WhatsApp siparis akisi hangi kullanicilar icin uygun?',
            'answer' => 'Dijital urun satanlar, butik isletmeler, influencerlar ve hizmet sunan profesyoneller icin hizli bir aksiyon noktasi saglar.',
        ],
        [
            'question' => 'Temalar mobilde de ayni sekilde calisir mi?',
            'answer' => 'Evet. Sistem responsive tasarlanir ve mobil kullanicinin tiklama, scroll ve siparis davranisina gore optimize edilir.',
        ],
    ];
@endphp

<section id="faq" data-scene="faq" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="text-center reveal" data-reveal>
            <div class="section-chip justify-center">
                <i class="fa-solid fa-circle-question text-cyan-300"></i>
                Sik sorulanlar
            </div>
            <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                Karar vermeden once merak edilenler.
            </h2>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                Her section bir soruya cevap veriyor; bu alan da son kararsizliklari gidermek icin tasarlandi.
            </p>
        </div>

        <div class="mt-12 space-y-4">
            @foreach ($faqs as $index => $faq)
                <article class="reveal rounded-[1.75rem] border transition" data-reveal :class="faqButtonClass({{ $index }})">
                    <button
                        type="button"
                        @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left sm:px-7"
                    >
                        <span class="text-lg font-semibold text-white">{{ $faq['question'] }}</span>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-300">
                            <i class="fa-solid" :class="activeFaq === {{ $index }} ? 'fa-minus' : 'fa-plus'"></i>
                        </span>
                    </button>
                    <div x-show="activeFaq === {{ $index }}" x-transition.opacity.duration.300ms class="px-6 pb-6 sm:px-7">
                        <p class="max-w-3xl text-sm leading-7 text-slate-300">{{ $faq['answer'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
