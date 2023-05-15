<x-layout>
    <x-slot name="title">Home</x-slot>

    <div class="my-8 flex flex-col items-center gap-16">
        <div class="text-center space-y-4">
            <p class="text-4xl md:text-6xl font-extrabold tracking-tighter"><span class="underline decoration-dashed decoration-teal-600">Save</span>, <span class="underline decoration-dashed decoration-teal-600">manage</span> and <span class="underline decoration-dashed decoration-teal-600">share</span> your bookmarks the easy
                way</p>
            <p class="text-gray-500">A free and simple-to-use solution to sync your bookmarks across multiple devices</p>
        </div>

        <a href="{{ route('bookmarks.index') }}"
            class="px-6 md:px-6 py-2 md:py-3 bg-teal-600 hover:opacity-80 text-gray-50 rounded-md flex items-center gap-2 w-fit transition">
            <span>Get started</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
            </svg>
        </a>
    </div>
</x-layout>
