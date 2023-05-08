<x-layout>
    <x-slot name="title">Bookmarks</x-slot>

    <div x-data="{ newBookmarkFormOpen: @error('url') {{"true"}} @else {{"false"}} @enderror, newFolderFormOpen: @error('folder_name') {{"true"}} @else {{"false"}} @enderror }">
        <div class="grid grid-cols-2 gap-4">
            <button class="flex flex-col gap-2 items-center border-2 border-dashed hover:border-gray-700 p-6 rounded-md font-medium transition-colors" x-on:click="newBookmarkFormOpen = !newBookmarkFormOpen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                </svg>
                <span>Add new bookmark</span>
            </button>
            <button class="flex flex-col gap-2 items-center border-2 border-dashed hover:border-gray-700 p-6 rounded-md font-medium transition-colors" x-on:click="newFolderFormOpen = !newFolderFormOpen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <span>Add new folder</span>
            </button>
        </div>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newBookmarkFormOpen" x-on:click="newBookmarkFormOpen = false" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center">
                <div x-transition.scale x-show="newBookmarkFormOpen" x-trap="newBookmarkFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-gray-300 p-6">
                    <p class="text-2xl font-bold">Add new bookmark</p>
                    <form action="{{ route('bookmarks.store') }}" method="POST" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-gray-600" for="name">Name</label>
                                <small class="text-xs text-gray-400">Optional</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="text" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-gray-600" for="url">URL</label>
                                <small class="text-xs text-gray-400">Required</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="url" name="url" id="url" value="{{ old('url') }}">
                                @error('url')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2" x-data="tags">
                            <div class="flex flex-col">
                                <label class="font-medium text-gray-600" for="tagsInput">Tags</label>
                                <small class="text-xs text-gray-400 max-w-[25ch]">Optional - Write out the name for a single tag then press <kbd class="p-[0.15rem] bg-gray-400 text-gray-100 rounded">Space</kbd> to create it</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="text" name="tagsInput" id="tagsInput" x-model="tagsInput" x-on:keyup.space="newTag">
                                <input type="hidden" name="tags" x-bind:value="tagsFormValue">
                                <div class="mt-2 flex gap-1 flex-wrap w-full">
                                    <template x-for="tag in tagsDisplay">
                                        <span class="py-1 px-4 flex items-center gap-1 text-sm rounded-full bg-gray-900 text-gray-50">
                                            <span x-text="tag"></span>
                                            <button x-on:click.prevent="removeTag(tag)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button x-on:click.prevent="newBookmarkFormOpen = false" class="basis-1/6 py-2 px-4 rounded bg-white border border-gray-300 shadow-sm">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded border border-gray-950 bg-gray-950 text-gray-50 shadow-sm" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newFolderFormOpen" x-on:click="newFolderFormOpen = false" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center">
                <div x-transition.scale x-show="newFolderFormOpen" x-trap="newFolderFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-gray-300 p-6">
                    <p class="text-2xl font-bold">Add new folder</p>
                    <form action="{{ route('folders.store') }}" method="post" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-gray-600" for="folder_name">Name</label>
                                <small class="text-xs text-gray-400">Required</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="text" name="folder_name" id="folder_name" value="{{ old('folder_name') }}">
                                @error('folder_name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-gray-600" for="is_private">Public</label>
                                <small class="text-xs text-gray-400 max-w-[25ch]">Determine if this folder is shareable or not</small>
                            </div>
                            <div class="flex flex-col">
                                <label
                                    x-data="{ isChecked: false }"
                                    for="is_public"
                                    class="relative h-8 w-14 cursor-pointer"
                                >
                                    <input
                                        x-model="isChecked"
                                        type="checkbox"
                                        id="is_public"
                                        name="is_public"
                                        class="peer sr-only"
                                    />

                                    <span
                                        :class="{ 'bg-gray-300': !isChecked, 'bg-green-500': isChecked }"
                                        class="absolute inset-0 rounded-full transition"
                                    ></span>

                                    <span
                                        :class="{ 'start-0': !isChecked, 'start-6': isChecked }"
                                        class="absolute inset-y-0 m-1 h-6 w-6 rounded-full bg-white transition-all"
                                    ></span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button x-on:click.prevent="newFolderFormOpen = false" class="basis-1/6 py-2 px-4 rounded bg-white border border-gray-300 shadow-sm">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded border border-gray-950 bg-gray-950 text-gray-50 shadow-sm" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <div class="my-8"">
        <p class="text-lg font-medium border-b border-gray-300 py-4">Folders</p>
        @foreach ($folders as $folder)
            <div>
                <div class="flex items-center justify-between gap-2 my-4 group relative">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M19.5 21a3 3 0 003-3v-4.5a3 3 0 00-3-3h-15a3 3 0 00-3 3V18a3 3 0 003 3h15zM1.5 10.146V6a3 3 0 013-3h5.379a2.25 2.25 0 011.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 013 3v1.146A4.483 4.483 0 0019.5 9h-15a4.483 4.483 0 00-3 1.146z" />
                        </svg>
                        <span class="truncate max-w-[30ch] group-hover:underline relative">
                            {{ $folder->name }}
                        </span>
                    </div>
                    <span class="text-sm text-gray-400 group-hover:hidden">{{ Carbon\Carbon::parse($folder->created_at)->diffForHumans() }}</span>
                    <div class="absolute right-0 overflow-hidden hidden group-hover:flex items-center border border-gray-300 divide-x divide-gray-300 bg-white rounded">
                        <a href="{{ route('folders.show', ['folder' => $folder]) }}" class="py-1 px-3 hover:bg-gray-950 hover:text-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </a>
                        <a href="{{ route('folders.edit', ['folder' => $folder]) }}" class="py-1 px-3 hover:bg-gray-950 hover:text-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <form action="{{ route('folders.destroy', ['folder' => $folder]) }}" method="post">
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
                <div class="pl-6 border-l-2 border-gray-800">
                    @foreach ($folder->bookmarks as $bookmark)
                        <div class="flex items-center justify-between gap-2 my-4 group relative">
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
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-8">
        <p class="text-lg font-medium border-b border-gray-300 py-4">Bookmarks</p>
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
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tags", () => ({
                tagsInput: "",
                tagsFormValue: "",
                tagsDisplay: [],
                newTag() {
                    const newTagName = this.tagsInput.trim()

                    if (!newTagName) return

                    const isNotDuplicated = this.tagsDisplay.every(t => t != newTagName)
                    if (isNotDuplicated) {
                        this.tagsDisplay.push(newTagName)
                    }

                    this.tagsInput = ""
                    this.tagsFormValue = this.tagsDisplay.join()
                },
                removeTag(tag) {
                    this.tagsDisplay = this.tagsDisplay.filter(t => t != tag)
                    this.tagsFormValue = this.tagsDisplay.join()
                }
            }))
        })
    </script>
</x-layout>