<footer class="bg-white dark:bg-gray-950 pt-20 pb-10 border-t border-gray-100 dark:border-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ url('/') }}" class="flex items-center gap-2 mb-6">
                    <x-application-logo class="h-8 w-auto" />
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">byoo<span class="text-indigo-600">.pro</span></span>
                </a>
                <p class="text-gray-500 dark:text-gray-400 max-w-xs mb-6">
                    {{ __('Dijital dünyanızı merkezileştirmek için ihtiyacınız olan tek araç. Şık, hızlı ve güvenli.') }}
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-6">{{ __('Ürün') }}</h4>
                <ul class="space-y-4">
                    <li><a href="#features" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('Özellikler') }}</a></li>
                    <li><a href="#showcase" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('Örnekler') }}</a></li>
                    <li><a href="{{ route('pricing') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('Fiyatlandırma') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-6">{{ __('Yasal') }}</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('Gizlilik Politikası') }}</a></li>
                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('Kullanım Şartları') }}</a></li>
                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-colors">{{ __('İletişim') }}</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-100 dark:border-gray-900 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} byoo.pro. {{ __('Tüm hakları saklıdır.') }}
            </p>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span>{{ __('Üreticiler için') }}</span>
                <i class="fas fa-heart text-rose-500"></i>
                <span>{{ __('ile yapıldı') }}</span>
            </div>
        </div>
    </div>
</footer>
