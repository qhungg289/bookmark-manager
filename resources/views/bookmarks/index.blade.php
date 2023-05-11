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
        <div class="border-b border-gray-300 py-4">
            <p class="text-lg font-medium">Folders</p>
            <button></button>
        </div>
        @foreach ($folders as $folder)
            <div>
                <x-folder :folder="$folder" />
                <div class="pl-6 border-l-2 border-gray-800">
                    @foreach ($folder->bookmarks as $bookmark)
                        <x-bookmark :bookmark="$bookmark" />
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-8">
        <p class="text-lg font-medium border-b border-gray-300 py-4">Bookmarks</p>
        @foreach ($bookmarks as $bookmark)
            <x-bookmark :bookmark="$bookmark" />
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