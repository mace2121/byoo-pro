<nav x-data="{ open: false }" class="bg-white dark:bg-black border-b border-gray-100 dark:border-gray-800 h-[65px] sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between h-full">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-800">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-7 w-auto fill-current text-black dark:text-white" />
                        <span class="text-lg font-black tracking-tighter text-gray-900 dark:text-white italic">byoo<span class="text-gray-400">.pro</span></span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="flex items-center sm:ms-6 gap-3">
                <a href="{{ route('profile.show', auth()->user()->username) }}" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-black dark:bg-white text-white dark:text-black rounded-xl text-xs font-black uppercase tracking-wider hover:opacity-80 transition-all shadow-lg shadow-black/5">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    {{ __('Sayfamı Gör') }}
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-black rounded-xl text-gray-500 dark:text-gray-400 bg-white dark:bg-black hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-cog mr-2 opacity-50"></i> {{ __('Ayarlar') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 opacity-50"></i> {{ __('Çıkış Yap') }}
                            </x-dropdown-link>

                            <hr class="my-2 border-gray-100 dark:border-gray-800">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-red-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i>
                                        {{ __('Çıkış Yap') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
