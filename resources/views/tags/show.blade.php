<x-layout>
    <x-slot name="title">#{{ $tag->name }}</x-slot>

    <x-heading>#{{ $tag->name }}</x-heading>

    <div class="mt-8 mb-2 flex justify-between text-gray-500">
        <span class="pl-7">Name</span>
        <span>Created</span>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($tag->bookmarks as $bookmark)
            <x-bookmark :bookmark="$bookmark" />
        @endforeach
    </div>
</x-layout>