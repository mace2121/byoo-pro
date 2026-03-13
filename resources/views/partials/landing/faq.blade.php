<section id="faq" class="py-24 bg-gray-50 dark:bg-gray-900/50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Sıkça Sorulan Sorular') }}</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Byoo.pro hakkında bilmeniz gereken her şey.') }}</p>
        </div>

        <div class="space-y-4" x-data="{ activeAccordion: null }">
            <!-- Item 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Byoo.pro gerçekten ücretsiz mi?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 1" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Evet! Byoo.pro\'nun temel özellikleri tamamen ücretsizdir. Bir kuruş ödemeden profilinizi oluşturabilir, sınırsız link ekleyebilir ve çeşitli temalar arasından seçim yapabilirsiniz.') }}
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Özel alan adımı nasıl bağlarım?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 2" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Profilinizi oluşturduktan sonra panelinizdeki Profil Ayarları bölümüne gidin. Orada Özel Alan Adı seçeneğini bulacaksınız. Sadece alan adınızı girin ve sağlanan basit DNS talimatlarını izleyin.') }}
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Tasarımı özelleştirebilir miyim?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 3 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 3" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Kesinlikle! Tema Motorumuz arka plan resimlerini, renkleri, buton stillerini değiştirmenize ve hatta tam kontrol istiyorsanız kendi özel CSS\'inizi eklemenize olanak tanır.') }}
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 4 ? null : 4)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Analizler nasıl çalışır?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 4 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 4" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Profil görüntülemelerinizi ve link tıklamalarınızı otomatik olarak takip ediyoruz. Hangi linklerin en iyi performansı gösterdiğini ve ziyaretçilerinizin nereden geldiğini panelinizde gerçek zamanlı olarak görebilirsiniz.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
