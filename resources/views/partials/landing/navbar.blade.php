<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-800' : 'bg-transparent'"
     class="fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">B</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">byoo<span class="text-indigo-600">.pro</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ __('Features') }}</a>
                <a href="#showcase" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ __('Showcase') }}</a>
                <a href="#faq" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ __('FAQ') }}</a>
                
                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>

                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-indigo-600 transition-colors">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-indigo-600 transition-colors">{{ __('Log in') }}</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 transition-all shadow-sm hover:shadow-md">
                                    {{ __('Get Started') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#features" class="block px-3 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-md">{{ __('Features') }}</a>
            <a href="#showcase" class="block px-3 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-md">{{ __('Showcase') }}</a>
            <a href="#faq" class="block px-3 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-md">{{ __('FAQ') }}</a>
            
            @if (Route::has('login'))
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-bold text-indigo-600">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600 dark:text-gray-300">{{ __('Log in') }}</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-bold text-indigo-600">{{ __('Get Started') }}</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>
