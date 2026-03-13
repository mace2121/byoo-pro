<div class="sticky top-8">
    <div class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-xl">
        <div class="w-[148px] h-[18px] bg-gray-800 top-0 left-1/2 -translate-x-1/2 absolute rounded-b-[1rem]"></div>
        <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[124px] rounded-s-lg"></div>
        <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[178px] rounded-s-lg"></div>
        <div class="h-[64px] w-[3px] bg-gray-800 absolute -end-[17px] top-[142px] rounded-e-lg"></div>
        <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white dark:bg-gray-900">
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
