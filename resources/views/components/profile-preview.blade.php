<div class="sticky top-8">
    <!-- Natural Preview Container -->
    <div class="relative mx-auto bg-white dark:bg-gray-900 rounded-[2rem] h-[650px] w-full max-w-[340px] shadow-2xl border-[8px] border-gray-100 dark:border-gray-800 overflow-hidden group">
        
        <!-- Browser/Device Header Decorator -->
        <div class="absolute top-0 left-0 right-0 h-10 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700 flex items-center px-4 gap-1.5 z-10 transition-colors group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/10">
            <div class="w-2.5 h-2.5 rounded-full bg-red-400/50"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-amber-400/50"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-green-400/50"></div>
            <div class="ml-2 flex-1 h-5 bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700 flex items-center px-2">
                <div class="w-full h-1 bg-gray-100 dark:bg-gray-800 rounded-full"></div>
            </div>
        </div>

        <!-- Iframe Content -->
        <div class="pt-10 w-full h-full">
            <iframe id="preview-iframe" src="{{ route('public.profile', $user->username) }}" class="w-full h-full border-none"></iframe>
        </div>
    </div>
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                </svg>
                Live Preview
            </span>
        </p>
    </div>
</div>

<script>
    function refreshPreview() {
        const iframe = document.getElementById('preview-iframe');
        if (iframe) {
            iframe.contentWindow.location.reload();
        }
    }
    
    // Listen for form submissions or alpine events to refresh
    window.addEventListener('profile-updated', () => refreshPreview());
    window.addEventListener('links-updated', () => refreshPreview());
</script>
