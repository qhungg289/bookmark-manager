<x-layout>
    <x-slot name="title">All tags</x-slot>

    <a href="{{ route('admin.index') }}" class="flex items-center gap-1 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <p>Admin</p>
    </a>

    <x-heading>Admin - All tags</x-heading>

    <div class="mt-8 mb-2 flex justify-between text-gray-500">
        <span class="pl-7">Name</span>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($tags as $tag)
            <div class="flex items-center gap-2 py-3 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                </svg>
                <a href="{{ route('tags.show', ['tag' => $tag]) }}" class="hover:underline">
                    {{ $tag->name }}
                </a>
            </div>
        @endforeach
    </div>
</x-layout>