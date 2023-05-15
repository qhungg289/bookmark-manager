<x-layout>
    <x-slot name="title">Edit {{ $bookmark->name }}</x-slot>

    <h1 class="text-4xl font-bold">Edit {{ $bookmark->name }}</h1>

    <form action="{{ route('bookmarks.update', ['bookmark' => $bookmark]) }}" method="post" class="mt-8 flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div class="grid">
            <div class="flex items-center gap-1">
                <label class="font-medium text-gray-600" for="name">Name</label>
                <small class="text-xs text-gray-400">(Optional)</small>
            </div>
            <div class="flex flex-col">
                <x-forms.input type="text" name="name" id="name" value="{{ old('name', $bookmark->name) }}" />
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
                <x-forms.input type="url" name="url" id="url" value="{{ old('url', $bookmark->url) }}" />
                @error('url')
                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="grid" x-data="tags" x-effect="console.log({tagsFormValue, tagsDisplay})">
            <div class="flex items-center gap-1">
                <label class="font-medium text-gray-600" for="tagsInput">Tags</label>
                <small class="text-xs text-gray-400">Optional - Write out the name for a single tag then press <kbd class="p-[0.15rem] bg-gray-400 text-gray-100 rounded">Space</kbd> to create it</small>
            </div>
            <div class="flex flex-col relative">
                <x-forms.input type="text" name="tagsInput" id="tagsInput" x-model="tagsInput" x-on:keyup.space="newTag" />
                <button x-show="tagsInput.length > 0" x-on:click.prevent="newTag" class="absolute right-2 top-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-teal-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                    </svg>
                </button>
                <input type="hidden" name="tags" x-bind:value="tagsFormValue">
                <div class="mt-2 flex gap-1 flex-wrap w-full">
                    <template x-for="tag in tagsDisplay">
                        <span class="py-1 px-4 flex items-center gap-1 text-sm rounded-full bg-teal-600 text-gray-50">
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

        <div class="flex gap-2">
            <button class="basis-1/6 py-2 px-4 rounded-md bg-teal-600 hover:opacity-80 text-gray-50 transition-all" type="submit">Save</button>
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