<x-layout>
    <x-slot name="title">Search</x-slot>

    <h1 class="text-4xl font-bold">Search</h1>

    <form action="{{ route('search') }}" method="get" class="grid grid-cols-5 my-6">
        <input type="search" name="q" id="q" placeholder="Search" value="{{ $searchString ?? '' }}" class="col-span-4 bg-gray-100 border-0 border-b-2 border-transparent outline-none focus:ring-0 focus:border-teal-400 rounded-l transition-all placeholder:text-gray-400">
        <button type="submit" class="bg-teal-600 text-gray-50 flex items-center justify-center rounded-r hover:opacity-80 transition-all">
            Search
        </button>
    </form>

    @isset($bookmarks)
        <div class="divide-y divide-gray-200">
            @foreach ($bookmarks as $bookmark)
                <x-bookmark :bookmark="$bookmark" />
            @endforeach
        </div>
    @endisset
</x-layout>