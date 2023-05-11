<x-layout>
    <x-slot name="title">{{ $bookmark->name }}</x-slot>

    <a href="{{ $bookmark->url }}" class="block group" target="_blank">
        <p class="text-4xl font-bold group-hover:underline relative w-fit">
            <span>{{ $bookmark->name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 bg-white border border-gray-300 rounded-md shadow-md absolute right-0 top-0 hidden group-hover:block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
        </p>
        <p class="text-gray-600 group-hover:underline">
            {{ $bookmark->url }}
        </p>
    </a>

    <div class="flex items-center gap-2 mt-6">
        <span class="font-medium">Tags:</span>
        <div class="flex gap-1 flex-wrap w-full">
            @foreach ($bookmark->tags as $tag)
                <a href="{{ route('tags.show', ['tag' => $tag]) }}" class="py-1 px-4 flex items-center rounded-full bg-gray-900 text-gray-50 hover:underline">
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-16 grid grid-cols-3 overflow-hidden border border-gray-300 rounded-md divide-x divide-gray-300">
        <button x-data="{ url: '{!! $bookmark->url !!}' }" x-on:click="navigator.clipboard.writeText(url)" class="flex items-center justify-center gap-2 hover:bg-gray-950 hover:text-gray-50 py-3 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
            </svg>
            <span>Copy URL</span>
        </button>
        @can('update', $bookmark )
            <a href="{{ route('bookmarks.edit', ['bookmark' => $bookmark]) }}" class="flex items-center justify-center gap-2 hover:bg-gray-950 hover:text-gray-50 py-3 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                <span>Edit</span>
            </a>
        @endcan
        @can('delete', $bookmark)
            <form action="{{ route('bookmarks.destroy', ['bookmark' => $bookmark]) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="w-full flex items-center justify-center gap-2 hover:bg-gray-950 hover:text-gray-50 py-3 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <span>Delete</span>
                </button>
            </form>
        @endcan
    </div>
</x-layout>