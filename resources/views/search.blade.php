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
            <div class="flex items-center justify-between gap-2 my-4 group relative" >
                <a class="flex items-center gap-2" href="{{ $bookmark->url }}" target="_blank">
                    <img class="w-5" src="{{ $bookmark->icon }}" alt="">
                    <span class="truncate max-w-[40ch] group-hover:underline relative">
                        {{ $bookmark->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 absolute top-0 right-0 bg-white hidden group-hover:block">
                            <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="text-xs text-gray-400">{{ parse_url($bookmark->url)['host'] }}</span>
                </a>
                <span class="text-sm text-gray-400 group-hover:hidden">{{ Carbon\Carbon::parse($bookmark->created_at)->diffForHumans() }}</span>
                <div class="absolute right-0 overflow-hidden hidden group-hover:flex items-center border border-gray-300 divide-x divide-gray-300 bg-white rounded">
                    <a href="{{ route('bookmarks.show', ['bookmark' => $bookmark]) }}" class="py-1 px-3 hover:bg-gray-950 hover:text-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </a>
                    <a href="{{ route('bookmarks.edit', ['bookmark' => $bookmark]) }}" class="py-1 px-3 hover:bg-gray-950 hover:text-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                    </a>
                    <form action="{{ route('bookmarks.destroy', ['bookmark' => $bookmark]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center py-1 px-3 hover:bg-gray-950 hover:text-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endisset
</x-layout>