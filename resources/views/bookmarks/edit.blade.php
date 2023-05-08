<x-layout>
    <x-slot name="title">Edit {{ $bookmark->name }}</x-slot>

    <h1 class="text-4xl font-bold">Edit {{ $bookmark->name }}</h1>

    <form action="{{ route('bookmarks.update', ['bookmark' => $bookmark]) }}" method="post" class="mt-8 flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2">
            <div class="flex flex-col">
                <label class="font-medium text-gray-600" for="name">Name</label>
                <small class="text-xs text-gray-400">Optional</small>
            </div>
            <div class="flex flex-col">
                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="text" name="name" id="name" value="{{ old('name', $bookmark->name) }}">
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
                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="url" name="url" id="url" value="{{ old('url', $bookmark->url) }}">
                @error('url')
                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2" x-data="tags" x-effect="console.log({tagsFormValue, tagsDisplay})">
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
            <button class="basis-1/6 py-2 px-4 rounded border border-gray-950 bg-gray-950 text-gray-50 shadow-sm" type="submit">Save</button>
        </div>
    </form>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tags", () => ({
                tagsInput: "",
                tagsFormValue: {!! json_encode($tags) !!},
                tagsDisplay: [],
                init() {
                    if (this.tagsFormValue) {
                        this.tagsDisplay = this.tagsFormValue.split(",")
                    }
                },
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