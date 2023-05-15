<x-layout>
    <x-slot name="title">#{{ $tag->name }}</x-slot>

    <x-heading>#{{ $tag->name }}</x-heading>

    <div class="my-8 divide-y divide-gray-200">
        @foreach ($tag->bookmarks as $bookmark)
            <x-bookmark :bookmark="$bookmark" />
        @endforeach
    </div>
</x-layout>