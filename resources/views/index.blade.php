<x-layout>
    <x-slot name="title">Home</x-slot>

    <div class="mb-4 absolute bottom-0">
        <p class="text-4xl md:text-6xl font-extrabold tracking-tighter">Save, manage and share your bookmarks the easy
            way</p>
        <a href="{{ route('bookmarks.index') }}"
            class="px-6 md:px-6 py-2 md:py-3 bg-gray-950 text-gray-50 rounded-full flex items-center gap-2 w-fit mt-8">
            <span>Get started</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
            </svg>
        </a>
    </div>
</x-layout>
