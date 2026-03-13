<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pricing Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">İhtiyacına Uygun Planı Seç</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Her plan daha fazla özellik ve limit sunar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($plans as $plan)
                    @php
                        $isCurrentPlan = auth()->check() && auth()->user()->subscription && auth()->user()->subscription->plan_id === $plan->id;
                        $colors = [
                            'free' => 'gray',
                            'pro' => 'indigo',
                            'business' => 'purple',
                        ];
                        $color = $colors[$plan->slug] ?? 'gray';
                    @endphp
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden {{ $isCurrentPlan ? 'ring-2 ring-indigo-500' : '' }}">
                        @if($isCurrentPlan)
                            <div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                                Mevcut Plan
                            </div>
                        @endif

                        <div class="p-8">
                            <h4 class="text-lg font-semibold text-{{ $color }}-600 dark:text-{{ $color }}-400 uppercase tracking-wide">
                                {{ $plan->name }}
                            </h4>

                            <div class="mt-4 flex items-baseline">
                                <span class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">
                                    ${{ number_format($plan->price, 2) }}
                                </span>
                                <span class="ml-1 text-lg text-gray-500 dark:text-gray-400">/ay</span>
                            </div>

                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $plan->description }}
                            </p>

                            <ul class="mt-6 space-y-3">
                                <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $plan->link_limit }} link
                                </li>
                                <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Tıklama Takibi
                                </li>
                            </ul>

                            <div class="mt-8">
                                @if($isCurrentPlan)
                                    <span class="block w-full text-center py-3 px-6 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-semibold cursor-default">
                                        Aktif Plan
                                    </span>
                                @else
                                    <span class="block w-full text-center py-3 px-6 rounded-lg bg-{{ $color }}-600 text-white font-semibold hover:bg-{{ $color }}-700 transition cursor-pointer">
                                        Yakında
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
