@props(['bookmark'])

<div class="flex items-center justify-between gap-2 py-3 group relative select-none" >
    <a class="flex items-center gap-2" href="{{ $bookmark->url }}" target="_blank">
        <img class="w-5" src="{{ $bookmark->icon }}" alt="">
        <span class="truncate max-w-[15ch] sm:max-w-[20ch] md:max-w-[40ch] group-hover:underline">
            {{ $bookmark->name }}
        </span>
        <span class="hidden sm:block text-xs text-gray-400">{{ parse_url($bookmark->url)['host'] }}</span>
    </a>
    <span class="text-sm text-gray-400 group-hover:hidden">{{ Carbon\Carbon::parse($bookmark->created_at)->diffForHumans() }}</span>
    <div class="absolute right-0 overflow-hidden hidden group-hover:flex items-center gap-1 bg-white rounded-md">
        @can('view', $bookmark)
            <a href="{{ route('bookmarks.show', ['bookmark' => $bookmark]) }}" class="py-1 px-3 bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </a>
        @endcan
        @can('update', $bookmark)
            <a href="{{ route('bookmarks.edit', ['bookmark' => $bookmark]) }}" class="py-1 px-3 bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
            </a>
        @endcan
        @can('delete', $bookmark)
            <form action="{{ route('bookmarks.destroy', ['bookmark' => $bookmark]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="py-1 px-3 bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </form>
        @endcan
    </div>
</div>