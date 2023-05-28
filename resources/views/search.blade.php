<x-layout>
    <x-slot name="title">Search</x-slot>

    <h1 class="text-4xl font-bold">Search</h1>

    <form action="{{ route('search') }}" method="get" class="grid grid-cols-5 my-6">
        <input type="search" name="q" id="q" placeholder="Search" value="{{ $searchString ?? '' }}" class="col-span-4 bg-gray-100 border-0 border-b-2 border-transparent outline-none focus:ring-0 focus:border-teal-400 rounded-l transition-all placeholder:text-gray-400">
        <button type="submit" class="bg-teal-600 text-gray-50 flex items-center justify-center rounded-r hover:opacity-80 transition-all">
            Search
        </button>
    </form>

    <div class="mt-8 mb-2 flex justify-between text-gray-500">
        <span class="pl-7">Name</span>
        <span>Created</span>
    </div>

    <div class="divide-y divide-gray-200">
        @isset($bookmarks)
            @foreach ($bookmarks as $bookmark)
                <x-bookmark :bookmark="$bookmark" />
            @endforeach
        @endisset
        @isset($folders)
            @foreach ($folders as $folder)
                <div x-data="{ expanded: false }">
                    <x-folder :folder="$folder" x-on:click="expanded = ! expanded" />
                    <div class="pl-8" x-show="expanded" x-collapse>
                        @foreach ($folder->bookmarks as $bookmark)
                            <x-bookmark :bookmark="$bookmark" />
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endisset
        @isset($tags)
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
        @endisset
    </div>
</x-layout>