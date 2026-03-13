<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 sticky top-0 z-40 h-16">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between h-full">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto fill-current text-indigo-600" />
                        <span class="text-lg font-black tracking-tighter text-gray-900 dark:text-white">byoo<span class="text-indigo-600">.pro</span></span>
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Quick View Link -->
                <a href="{{ route('public.profile', Auth::user()->username) }}" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-indigo-100 transition-all border border-indigo-100 dark:border-indigo-800">
                    <i class="fas fa-external-link-alt"></i>
                    {{ __('Sayfayı Görüntüle') }}
                </a>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 p-1.5 rounded-xl border border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-black text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left mr-2">
                                    <p class="text-[10px] font-black uppercase text-gray-400 leading-none">Hesabım</p>
                                    <p class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-[10px] text-gray-400 mr-1"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-shield text-indigo-600"></i>
                                        {{ __('Admin Paneli') }}
                                    </div>
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user"></i>
                                    {{ __('Profil Ayarları') }}
                                </div>
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
