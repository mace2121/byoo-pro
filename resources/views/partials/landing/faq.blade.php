<section id="faq" class="py-24 bg-gray-50 dark:bg-gray-900/50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Common Questions') }}</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Everything you need to know about byoo.pro.') }}</p>
        </div>

        <div class="space-y-4" x-data="{ activeAccordion: null }">
            <!-- Item 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Is byoo.pro really free?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 1" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Yes! The core features of byoo.pro are completely free. You can create your profile, add unlimited links, and choose from multiple themes without paying a cent.') }}
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('How do I link my custom domain?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 2" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Once you create your profile, go to the Profile Settings section in your dashboard. There you will find the Custom Domain option. Just enter your domain and follow the simple DNS instructions provided.') }}
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('Can I customize the design?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 3 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 3" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Absolutely! Our Theme Engine allows you to change background images, colors, button styles, and even add your own custom CSS if you want complete control.') }}
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <button @click="activeAccordion = (activeAccordion === 4 ? null : 4)" 
                        class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('How do analytics work?') }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300" :class="activeAccordion === 4 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeAccordion === 4" x-collapse x-cloak>
                    <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('We track your profile views and link clicks automatically. You can see real-time data in your dashboard, including which links are performing best and where your visitors are coming from.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
