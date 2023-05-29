<x-layout>
    <x-slot name="title">Bookmarks</x-slot>

    <div x-data="{ newBookmarkFormOpen: @error('url') {{"true"}} @else {{"false"}} @enderror, newFolderFormOpen: @error('folder_name') {{"true"}} @else {{"false"}} @enderror }">
        <form action="{{ route('search') }}" method="get" class="grid grid-cols-5">
            <input type="search" name="q" id="q" placeholder="Search" class="col-span-4 bg-gray-100 border-0 border-b-2 border-transparent outline-none focus:ring-0 focus:border-teal-400 rounded-l transition-all placeholder:text-gray-400">
            <button type="submit" class="bg-teal-600 text-gray-50 flex items-center justify-center rounded-r hover:opacity-80 transition-all">
                Search
            </button>
        </form>

        <div class="grid md:grid-cols-2 gap-4 mt-4">
            <button class="flex items-center md:justify-center gap-2 bg-gray-100 p-2 rounded-md hover:bg-gray-200 transition-all" x-on:click="newBookmarkFormOpen = !newBookmarkFormOpen">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Add new bookmark
            </button>
            <button class="flex items-center md:justify-center gap-2 bg-gray-100 p-2 rounded-md hover:bg-gray-200 transition-all" x-on:click="newFolderFormOpen = !newFolderFormOpen">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Add new folder
            </button>
        </div>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newBookmarkFormOpen" x-on:click="newBookmarkFormOpen = false" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center">
                <div x-trap="newBookmarkFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-gray-300 p-6">
                    <p class="text-2xl font-bold">Add new bookmark</p>
                    <form action="{{ route('bookmarks.store') }}" method="POST" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid">
                            <div class="flex items-center gap-1">
                                <label class="font-medium text-gray-600" for="name">Name</label>
                                <small class="text-xs text-gray-400">(Optional)</small>
                            </div>
                            <div class="flex flex-col">
                                <x-forms.input type="text" name="name" id="name" value="{{ old('name') }}" />
                                @error('name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid">
                            <div class="flex items-center gap-1">
                                <label class="font-medium text-gray-600" for="url">URL</label>
                                <small class="text-xs text-gray-400">(Required)</small>
                            </div>
                            <div class="flex flex-col">
                                <x-forms.input type="url" name="url" id="url" value="{{ old('url') }}" />
                                @error('url')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid" x-data="tags">
                            <div class="flex items-center gap-1">
                                <label class="font-medium text-gray-600" for="tagsInput">Tags</label>
                                <small class="text-xs text-gray-400">(Optional) - Write out the name for a single tag then press <kbd class="p-[0.15rem] bg-gray-400 text-gray-100 rounded">Space</kbd> or <kbd class="p-[0.15rem] bg-gray-400 text-gray-100 rounded">Enter</kbd> to create it</small>
                            </div>
                            <div class="flex flex-col relative">
                                <x-forms.input type="text" name="tagsInput" id="tagsInput" x-model="tagsInput" x-on:keyup.space="newTag" x-on:keyup.enter.prevent="" />
                                <button x-show="tagsInput.length > 0" x-on:click.prevent="newTag" class="absolute right-2 top-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-teal-600">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="hidden" name="tags" x-bind:value="tagsFormValue">
                                <div class="mt-2 flex gap-1 flex-wrap w-full">
                                    <template x-for="tag in tagsDisplay">
                                        <span class="py-1 px-4 flex items-center gap-1 text-sm rounded-full bg-gray-300">
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
                            <button x-on:click.prevent="newBookmarkFormOpen = false" class="basis-1/6 py-2 px-4 rounded-md bg-gray-100 hover:bg-gray-200 transition-all">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded-md bg-teal-600 hover:opacity-80 text-gray-50 transition-all" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newFolderFormOpen" x-on:click="newFolderFormOpen = false" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center">
                <div x-trap="newFolderFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-gray-300 p-6">
                    <p class="text-2xl font-bold">Add new folder</p>
                    <form action="{{ route('folders.store') }}" method="post" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid">
                            <div class="flex items-center gap-1">
                                <label class="font-medium text-gray-600" for="folder_name">Name</label>
                                <small class="text-xs text-gray-400">(Required)</small>
                            </div>
                            <div class="flex flex-col">
                                <x-forms.input type="text" name="folder_name" id="folder_name" value="{{ old('folder_name') }}" />
                                @error('folder_name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid">
                            <div class="flex items-center gap-1">
                                <label class="font-medium text-gray-600" for="is_private">Public</label>
                                <small class="text-xs text-gray-400">Determine if this folder is shareable or not</small>
                            </div>
                            <div class="flex flex-col">
                                <label
                                    x-data="{ isChecked: false }"
                                    for="is_public"
                                    class="relative mt-1 h-8 w-14 cursor-pointer"
                                >
                                    <input
                                        x-model="isChecked"
                                        type="checkbox"
                                        id="is_public"
                                        name="is_public"
                                        class="peer sr-only"
                                    />

                                    <span
                                        :class="{ 'bg-gray-200': !isChecked, 'bg-teal-500': isChecked }"
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
                            <button x-on:click.prevent="newFolderFormOpen = false" class="basis-1/6 py-2 px-4 rounded-md bg-gray-100 hover:bg-gray-200 transition-all">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded-md bg-teal-600 hover:opacity-80 text-gray-50 transition-all" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <div class="my-8">
        <div class="grid grid-cols-3 bg-gray-100 rounded-md p-1">
            <a class="text-center p-1 rounded @if (!str_contains(url()->full(), 'filter=bookmarks') && !str_contains(url()->full(), 'filter=folders')) bg-white shadow @endif" href="{{ route('bookmarks.index') }}">All</a>
            <a class="text-center p-1 rounded @if (str_contains(url()->full(), 'filter=bookmarks')) bg-white shadow @endif" href="?filter=bookmarks">Bookmarks</a>
            <a class="text-center p-1 rounded @if (str_contains(url()->full(), 'filter=folders')) bg-white shadow @endif" href="?filter=folders">Folders</a>
        </div>

        <div class="flex items-center justify-end py-4 relative" x-data="{ open: false }">
            <button class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md" x-on:click="open = ! open">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>
                <span>Sort</span>
            </button>

            <div x-show="open" x-cloak x-transition x-on:click.outside="open = false" class="absolute isolate z-50 right-0 top-16 flex flex-col bg-white border border-gray-300 rounded">
                <a class="flex items-center gap-2 py-2 px-4 hover:underline" href="{{ route('bookmarks.index', ['sort' => 'name_asc', 'filter' => request()->query('filter')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if (str_contains(url()->full(), 'sort=name_asc')) visible @else invisible @endif">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Name: Ascending
                </a>
                <a class="flex items-center gap-2 py-2 px-4 hover:underline" href="{{ route('bookmarks.index', ['sort' => 'name_desc', 'filter' => request()->query('filter')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if (str_contains(url()->full(), 'sort=name_desc')) visible @else invisible @endif">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Name: Descending
                </a>
                <a class="flex items-center gap-2 py-2 px-4 hover:underline" href="{{ route('bookmarks.index', ['sort' => 'created_latest', 'filter' => request()->query('filter')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if (str_contains(url()->full(), 'sort=created_latest')) visible @else invisible @endif">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Created: Latest
                </a>
                <a class="flex items-center gap-2 py-2 px-4 hover:underline" href="{{ route('bookmarks.index', ['sort' => 'created_oldest', 'filter' => request()->query('filter')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if (str_contains(url()->full(), 'sort=created_oldest')) visible @else invisible @endif">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Created: Oldest
                </a>
            </div>
        </div>

        <div class="mb-2 flex justify-between text-gray-500">
            <span class="pl-7">Name</span>
            <span>Created</span>
        </div>
        <div class="divide-y divide-gray-200">
            @isset($folders)
                @foreach ($folders as $folder)
                    <div x-data="{ expanded: false }">
                        <x-folder :folder="$folder" x-on:click="expanded = ! expanded" />
                        <div class="pl-8" x-show="expanded" x-collapse x-cloak>
                            @foreach ($folder->bookmarks as $bookmark)
                                <x-bookmark :bookmark="$bookmark" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endisset

            @isset($bookmarks)
                @foreach ($bookmarks as $bookmark)
                    <x-bookmark :bookmark="$bookmark" />
                @endforeach
            @endisset
        </div>
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