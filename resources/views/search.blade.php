<x-layout>
    <x-slot name="title">Search</x-slot>

    <h1 class="text-4xl font-bold">Search</h1>

    <form action="{{ route('search') }}" method="get" class="my-6">
        <div class="grid grid-cols-6">
            <input type="search" name="q" id="q" placeholder="Search" value="{{ $searchString ?? '' }}" class="col-span-5 border border-gray-300 focus:border-gray-500 focus:ring-0 rounded-l shadow-sm">
            <button type="submit" class="bg-gray-950 text-gray-50 flex items-center justify-center shadow-sm rounded-r">
                Search
            </button>
        </div>
    </form>

    @isset($bookmarks)
        @foreach ($bookmarks as $bookmark)
            <x-bookmark :bookmark="$bookmark" />
        @endforeach
    @endisset
</x-layout>