<x-layout>
    <x-slot name="title">{{ $tag->name }}</x-slot>

    <h1 class="text-4xl font-bold">{{ $tag->name }}</h1>

    <p class="text-lg font-medium border-b border-gray-300 py-4 mt-8">Bookmarks</p>
    @foreach ($tag->bookmarks as $bookmark)
        <x-bookmark :bookmark="$bookmark" />
    @endforeach
</x-layout>