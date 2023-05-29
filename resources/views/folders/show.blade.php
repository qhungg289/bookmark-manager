<x-layout>
    <x-slot name="title">{{ $folder->name }}</x-slot>

    <x-heading>{{ $folder->name }}</x-heading>
    @if (auth()->user()->id != $folder->user_id)
        <h2 class="text-sm text-gray-500 mt-2">by {{ $folder->user->name }}</h2>
    @endif

    @canany(['update', 'delete'], $folder)
        <div class="mt-8 grid md:grid-cols-2 gap-4">
            <a href="{{ route('folders.edit', ['folder' => $folder]) }}" class="flex items-center justify-center gap-2 p-3 bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                <span>Edit</span>
            </a>
            <form action="{{ route('folders.destroy', ['folder' => $folder]) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <span>Delete</span>
                </button>
            </form>
        </div>
    @endcanany

    <div class="mt-8 mb-2 flex justify-between text-gray-500">
        <span class="pl-7">Name</span>
        <span>Created</span>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($folder->bookmarks as $bookmark)
            <x-bookmark :bookmark="$bookmark" />
        @endforeach
    </div>

    <div class="mt-8">
        <form action="{{ route('comments.store') }}" method="post" class="flex flex-col gap-3">
            @csrf

            <input type="hidden" name="folder_id" value="{{ $folder->id }}">

            <div class="flex flex-col">
                <x-forms.input type="text" name="comment" id="comment" placeholder="Comment..." value="{{ old('comment') }}" />
                @error('comment')
                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                @enderror
            </div>

            <button class="w-fit bg-teal-600 text-gray-50 px-6 py-3 rounded-md hover:opacity-80 transition-all" type="submit">Send</button>
        </form>

        <div class="mt-4 space-y-2">
            @foreach ($folder->comments as $comment)
                <div class="p-4 border border-gray-300 rounded-md space-y-4">
                    <div class="flex gap-2 text-sm">
                        <a class="hover:underline" href="{{ route('profiles.show', ['user' => $comment->user]) }}">{{ $comment->user->name }}</a>
                        <span class="text-gray-400">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                        @can('update', $comment)
                            <a href="{{ route('comments.edit', ['comment' => $comment]) }}">Edit</a>
                        @endcan
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', ['comment' => $comment]) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit">Delete</button>
                            </form>
                        @endcan
                    </div>
                    <div class="text-lg border-l-2 border-gray-300 pl-4">
                        {{ $comment->content }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>