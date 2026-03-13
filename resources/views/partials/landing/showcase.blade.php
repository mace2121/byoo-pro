<section id="showcase" class="py-24 overflow-hidden bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-16">
            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('One link to rule them all') }}</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ __('Join thousands of creators, entrepreneurs, and artists who trust byoo to showcase their work.') }}</p>
            </div>
            <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-2 group">
                {{ __('Start building your own') }}
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Profile 1 -->
            <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1">
                <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=600" alt="Art Profile" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full text-white">
                    <p class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-1">Artist</p>
                    <h3 class="text-lg font-bold">@marcus.design</h3>
                </div>
            </div>

            <!-- Profile 2 -->
            <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=600" alt="Founder Profile" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full text-white">
                    <p class="text-xs font-bold uppercase tracking-widest text-purple-400 mb-1">Founder</p>
                    <h3 class="text-lg font-bold">@sarah.ventures</h3>
                </div>
            </div>

            <!-- Profile 3 -->
            <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 sm:hidden lg:block">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600" alt="Writer Profile" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full text-white">
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-400 mb-1">Writer</p>
                    <h3 class="text-lg font-bold">@james.notes</h3>
                </div>
            </div>

            <!-- Profile 4 -->
            <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 sm:hidden lg:block">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=600" alt="Chef Profile" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full text-white">
                    <p class="text-xs font-bold uppercase tracking-widest text-amber-400 mb-1">Chef</p>
                    <h3 class="text-lg font-bold">@chef.lina</h3>
                </div>
            </div>
        </div>
    </div>
</section>
