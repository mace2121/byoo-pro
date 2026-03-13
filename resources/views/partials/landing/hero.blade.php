<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-100/50 dark:bg-indigo-900/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[10%] right-[-5%] w-[30%] h-[30%] bg-purple-100/50 dark:bg-purple-900/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 text-indigo-700 dark:text-indigo-400 text-xs font-bold mb-6 animate-fade-in">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            {{ __('New: Advanced Theme engine is live!') }}
        </div>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6">
            {{ __('All your links in') }} <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                {{ __('one beautiful page.') }}
            </span>
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-10">
            {{ __('Create a personal landing page for your social media, business, or portfolio in seconds. Fully customizable, powerful analytics, and professional look.') }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full text-lg transition-all shadow-lg hover:shadow-indigo-500/25">
                {{ __('Claim your free page') }}
            </a>
            <a href="#showcase" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-bold rounded-full text-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                {{ __('See Examples') }}
            </a>
        </div>

        <!-- Mockup Preview -->
        <div class="mt-16 lg:mt-24 relative max-w-5xl mx-auto">
            <div class="relative rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 shadow-2xl">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=2426&ixlib=rb-4.0.3" alt="Dashboard Preview" class="w-full h-auto">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/20 to-transparent"></div>
            </div>
            
            <!-- Floaties (Optional decorations) -->
            <div class="hidden lg:block absolute -top-8 -left-8 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 transform -rotate-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ __('Views Today') }}</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">+1,284</p>
                    </div>
                </div>
            </div>
            
            <div class="hidden lg:block absolute -bottom-10 -right-10 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 transform rotate-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ __('Custom CSS') }}</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Enabled') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
