<div x-data="{ open: false }">
    <img src="{{ $src }}" alt="{{ $alt ?? 'Image' }}"
        class="{{ $class ?? 'w-24 h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:opacity-80 transition' }}"
        @click="open = true">

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
        @click="open = false" style="display: none;">

        <img src="{{ $src }}" class="max-w-full max-h-full rounded shadow-2xl" @click.stop>

        <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>