<x-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <div class="mb-6 pb-6">
        <p class="text-6xl font-medium">{{ $user->name }}</p>
        <p class="mt-4 text-gray-500">{{ $user->email }}</p>
        <p class="text-gray-500">Joined {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
        @if ($isOwner)
            <div class="flex items-center gap-2 mt-8">
                <a href="{{ route('profiles.edit', ['user' => $user]) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition-all rounded-md block">Edit</a>
                <a href="{{ route('profiles.edit-password', ['user' => $user]) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition-all rounded-md block">Change password</a>
            </div>
        @endif
    </div>

    <div>
        <p class="text-2xl font-bold">Public folders</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
            @foreach ($publicFolders as $folder)
                <a href="{{ route('folders.show', ['folder' => $folder]) }}" class="block bg-gray-100 hover:bg-gray-200 transition-all p-4 rounded-md">
                    <div class="flex flex-col gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        <p class="text-lg font-medium truncate">{{ $folder->name }}</p>
                    </div>
                    <p class="text-sm text-gray-400">Bookmarks: {{ count($folder->bookmarks) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>