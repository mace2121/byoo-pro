<x-app-layout>
    <div class="py-6" x-data="{ tab: 'stats' }">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Main Content Area -->
                <div class="flex-1">
                    <!-- Tabs Navigation -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                            <button @click="tab = 'stats'" :class="tab === 'stats' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Analytics') }}
                            </button>
                            <button @click="tab = 'links'" :class="tab === 'links' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('My Links') }}
                            </button>
                            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Profile Display') }}
                            </button>
                            <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Appearance') }}
                            </button>
                            <button @click="tab = 'settings'" :class="tab === 'settings' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Settings') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="space-y-6">
                        
                        <!-- Stats Tab -->
                        <div x-show="tab === 'stats'" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @include('dashboard.partials.stats-cards')
                        </div>

                        <!-- Links Tab -->
                        <div x-show="tab === 'links'" x-cloak>
                            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                                @include('dashboard.partials.links-management')
                            </div>
                        </div>

                        <!-- Profile Display Tab -->
                        <div x-show="tab === 'profile'" x-cloak class="space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-custom-domain-form')
                                </div>
                            </div>
                        </div>

                        <!-- Appearance Tab -->
                        <div x-show="tab === 'appearance'" x-cloak>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-theme-form')
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div x-show="tab === 'settings'" x-cloak class="space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-t-4 border-red-500">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Preview Area (Sidebar) -->
                <div class="hidden lg:block w-[350px]">
                    <x-profile-preview :user="$user" />
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
