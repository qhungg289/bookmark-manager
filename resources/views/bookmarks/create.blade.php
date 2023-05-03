<x-layout>
    <x-slot name="title">Create</x-slot>

    <h1>Create a new bookmark</h1>

    <form action="{{ route('bookmarks.store') }}" method="post">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            @error('name')
                <small>{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="url">URL</label>
            <input type="url" name="url" id="url">
            @error('url')
                <small>{{ $message }}</small>
            @enderror
        </div>

        <div x-data="tags">
            <label for="tagsInput">Tags</label>
            <input type="text" name="tagsInput" id="tagsInput" x-model="tagsInput" x-on:keyup.space="newTag">
            <input type="hidden" name="tags" x-bind:value="tagsFormValue">
            <div>
                <template x-for="tag in tagsDisplay">
                    <span x-text="tag"></span>
                </template>
            </div>
        </div>

        <button type="submit">Save</button>
    </form>

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
                removeTag() {}
            }))
        })
    </script>
</x-layout>