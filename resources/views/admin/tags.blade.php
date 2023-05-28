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
        <span>Name</span>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($tags as $tag)
            <a href="{{ route('tags.show', ['tag' => $tag]) }}" class="block py-3 hover:underline">#{{ $tag->name }}</a>
        @endforeach
    </div>
</x-layout>