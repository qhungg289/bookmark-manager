<x-layout>
    <x-slot name="title">Bookmarks</x-slot>

    <div x-data="{ newBookmarkFormOpen: @error('url') {{"true"}} @else {{"false"}} @enderror, newFolderFormOpen: @error('folder_name') {{"true"}} @else {{"false"}} @enderror }">
        <div>
            <button x-on:click="newBookmarkFormOpen = !newBookmarkFormOpen">Add new bookmark</button>
            <button x-on:click="newFolderFormOpen = !newFolderFormOpen">Add new folder</button>
        </div>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newBookmarkFormOpen" x-on:click="newBookmarkFormOpen = false" class="absolute inset-0 bg-slate-900/50 flex items-center justify-center">
                <div x-transition.scale x-show="newBookmarkFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-slate-300 p-6">
                    <p class="text-2xl font-bold">Add new bookmark</p>
                    <form action="{{ route('bookmarks.store') }}" method="POST" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-slate-600" for="name">Name</label>
                                <small class="text-xs text-slate-400">Optional</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-slate-300 focus:border-slate-300 focus:ring-2 focus:ring-offset-2 focus:ring-slate-400 rounded shadow" type="text" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-slate-600" for="url">URL</label>
                                <small class="text-xs text-slate-400">Required</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-slate-300 focus:border-slate-300 focus:ring-2 focus:ring-offset-2 focus:ring-slate-400 rounded shadow" type="url" name="url" id="url" value="{{ old('url') }}">
                                @error('url')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2" x-data="tags">
                            <div class="flex flex-col">
                                <label class="font-medium text-slate-600" for="tagsInput">Tags</label>
                                <small class="text-xs text-slate-400 max-w-[25ch]">Optional - Write out the name for a single tag then press <kbd class="p-[0.15rem] bg-slate-400 text-slate-100 rounded">Space</kbd> to create it</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-slate-300 focus:border-slate-300 focus:ring-2 focus:ring-offset-2 focus:ring-slate-400 rounded shadow" type="text" name="tagsInput" id="tagsInput" x-model="tagsInput" x-on:keyup.space="newTag">
                                <input type="hidden" name="tags" x-bind:value="tagsFormValue">
                                <div class="mt-2 flex gap-1 flex-wrap w-full">
                                    <template x-for="tag in tagsDisplay">
                                        <span class="py-1 px-4 flex items-center gap-1 text-sm rounded-full bg-slate-900 text-slate-50">
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
                            <button x-on:click.prevent="newBookmarkFormOpen = false" class="basis-1/6 py-2 px-4 rounded bg-white border border-slate-300 shadow">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded border border-slate-950 bg-slate-950 text-slate-50 shadow" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-teleport="body">
            <div x-transition.opacity x-show="newFolderFormOpen" x-on:click="newFolderFormOpen = false" class="absolute inset-0 bg-slate-900/50 flex items-center justify-center">
                <div x-transition.scale x-show="newFolderFormOpen" x-on:click.stop="" class="bg-white w-full max-w-4xl m-4 rounded-lg border border-slate-300 p-6">
                    <p class="text-2xl font-bold">Add new folder</p>
                    <form action="{{ route('folders.store') }}" method="post" class="mt-8 flex flex-col gap-4">
                        @csrf

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-slate-600" for="folder_name">Name</label>
                                <small class="text-xs text-slate-400">Required</small>
                            </div>
                            <div class="flex flex-col">
                                <input class="border border-slate-300 focus:border-slate-300 focus:ring-2 focus:ring-offset-2 focus:ring-slate-400 rounded shadow" type="text" name="folder_name" id="folder_name" value="{{ old('folder_name') }}">
                                @error('folder_name')
                                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <label class="font-medium text-slate-600" for="is_private">Public</label>
                                <small class="text-xs text-slate-400 max-w-[25ch]">Determine if this folder is shareable or not</small>
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
                            <button x-on:click.prevent="newFolderFormOpen = false" class="basis-1/6 py-2 px-4 rounded bg-white border border-slate-300 shadow">Cancel</button>
                            <button class="basis-1/6 py-2 px-4 rounded border border-slate-950 bg-slate-950 text-slate-50 shadow" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tags", () => ({
                tagsInput: "",
                tagsFormValue: "",
                tagsDisplay: [],
                newTag() {
                    if (this.tagsInput.trim()) {
                        if (this.tagsDisplay.some(t => t == this.tagsInput.trim()) == false) {
                            this.tagsDisplay.push(this.tagsInput.trim())
                        }
                        this.tagsInput = ""
                        this.tagsFormValue = this.tagsDisplay.join(",")
                    }
                },
                removeTag(tag) {
                    this.tagsDisplay = this.tagsDisplay.filter(t => t != tag)
                    this.tagsFormValue = this.tagsDisplay.join(",")
                }
            }))
        })
    </script>
</x-layout>