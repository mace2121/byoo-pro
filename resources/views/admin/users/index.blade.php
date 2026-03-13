<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <x-section-header 
                    :title="__('Kullanıcı Yönetimi')" 
                    :subtitle="__('Platformdaki tüm kullanıcıları inceleyin, durumlarını yönetin ve sistem erişimlerini kontrol edin.')" 
                />
            </div>
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span class="text-sm font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-8">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <x-text-input name="search" value="{{ $search ?? '' }}" placeholder="İsim, kullanıcı adı veya e-posta ile ara..." class="w-full pl-11 h-12 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900" />
                            </div>
                            <div class="flex gap-2">
                                <x-primary-button type="submit" class="h-12 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">
                                    {{ __('Search') }}
                                </x-primary-button>
                                @if($search)
                                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-black text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                        {{ __('Clear') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        KULLANICI
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        LİNK
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        GÖRÜNTÜLENME / TIK
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        DURUM
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">
                                        KAYIT TARİHİ
                                    </th>
                                    <th scope="col" class="relative px-6 py-4 text-right">
                                        <span class="sr-only">İşlemler</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-400">
                                            #{{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center mr-4 text-sm font-black text-indigo-600 dark:text-indigo-400">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="text-sm font-black text-gray-900 dark:text-gray-100">
                                                            {{ $user->name }}
                                                        </div>
                                                        @if($user->is_admin)
                                                            <span class="px-2 py-0.5 text-[9px] font-black rounded-lg bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 uppercase tracking-widest border border-purple-200 dark:border-purple-800/50">
                                                                Admin
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400">
                                                        {{ '@' . $user->username }} <span class="mx-1 opacity-30">|</span> {{ $user->email }}
                                                    </div>
                                                    @if($user->profile && $user->profile->bio)
                                                        <div class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 max-w-[200px] truncate italic">
                                                            "{{ $user->profile->bio }}"
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 text-xs font-black bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-100 dark:border-gray-700">
                                                {{ $user->links_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs font-black text-indigo-600 dark:text-indigo-400">
                                                    <i class="fas fa-eye mr-1 text-[10px]"></i> {{ number_format($user->profile->views ?? 0) }}
                                                </span>
                                                <span class="text-[9px] text-gray-400 uppercase tracking-widest font-black mt-1">
                                                    <i class="fas fa-mouse-pointer mr-1"></i> {{ number_format($user->links->sum('clicks')) }} TIK
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->is_active)
                                                <span class="px-3 py-1 text-[9px] font-black rounded-lg bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 uppercase tracking-widest border border-green-100 dark:border-green-800/50">
                                                    AKTİF
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-[9px] font-black rounded-lg bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400 uppercase tracking-widest border border-red-100 dark:border-red-800/50">
                                                    ASKIDA
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[11px] font-bold text-gray-500 dark:text-gray-400">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($user->id !== auth()->id())
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('public.profile', $user->username) }}" target="_blank" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors" title="{{ __('View Profile') }}">
                                                        <i class="fas fa-external-link-alt text-lg"></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('admin.users.impersonate', $user) }}" class="p-2 text-indigo-400 hover:text-indigo-600 transition-colors" title="{{ __('Login as User') }}">
                                                        <i class="fas fa-user-secret text-lg"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="p-2 {{ $user->is_active ? 'text-amber-400 hover:text-amber-600' : 'text-green-400 hover:text-green-600' }} transition-colors" title="{{ $user->is_active ? __('Suspend') : __('Activate') }}">
                                                            <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }} text-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center font-bold">
                                            <div class="flex flex-col items-center gap-3">
                                                <i class="fas fa-users-slash text-4xl opacity-20"></i>
                                                {{ __('No users found.') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
