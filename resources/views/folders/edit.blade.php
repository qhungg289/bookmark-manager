<x-layout>
    <x-slot name="title">Edit {{ $folder->name }}</x-slot>

    <x-heading>Edit {{ $folder->name }} folder</x-heading>

    <form action="{{ route('folders.update', ['folder' => $folder] ) }}" method="post" class="mt-8 flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div class="grid">
            <div class="flex items-center gap-1">
                <label class="font-medium text-gray-600" for="name">Name</label>
                <small class="text-xs text-gray-400">(Required)</small>
            </div>
            <div class="flex flex-col">
                <x-forms.input type="text" name="name" id="name" value="{{ old('name', $folder->name) }}" />
                @error('name')
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
                    x-data="{ isChecked: @if (boolval($folder->is_public)) {{ "true" }} @else {{ "false" }} @endif }"
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

        <div class="grid">
            <div class="flex items-center gap-1">
                <label class="font-medium text-gray-600" for="bookmarks">Bookmarks</label>
            </div>
            <div class="bg-gray-100 rounded px-4 mt-1 h-56 overflow-auto" x-data="bookmarks">
                <input type="hidden" name="bookmarks" x-bind:value="bookmarksFormValue">

                @foreach ($folder->bookmarks as $bookmark)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input class="rounded bg-gray-100 text-teal-600 border-none outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-400 transition-all" type="checkbox" checked value="{{ $bookmark->id }}" x-on:change="handleCheck($el)" x-init="handleCheck($el)">
                        <span class="flex items-center gap-2 my-4 group">
                            <img class="w-5" src="{{ $bookmark->icon }}" alt="">
                            <span class="truncate max-w-[30ch] relative">
                                {{ $bookmark->name }}
                            </span>
                        </span>
                    </label>
                @endforeach

                @foreach ($bookmarks as $bookmark)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input class="rounded bg-gray-100 text-teal-600 border-none outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-400 transition-all" type="checkbox" value="{{ $bookmark->id }}" x-on:change="handleCheck($el)" x-init="handleCheck($el)">
                        <span class="flex items-center gap-2 my-4 group">
                            <img class="w-5" src="{{ $bookmark->icon }}" alt="">
                            <span class="truncate max-w-[30ch] relative">
                                {{ $bookmark->name }}
                            </span>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-2">
            <button class="basis-1/6 py-2 px-4 rounded-md bg-teal-600 hover:opacity-80 text-gray-50 transition-all" type="submit">Save</button>
        </div>
    </form>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("bookmarks", () => ({
                bookmarksFormValue: "",
                bookmarksId: [],
                handleCheck(checkbox) {
                    if (checkbox.checked) {
                        this.bookmarksId.push(checkbox.value)
                    } else {
                        this.bookmarksId = this.bookmarksId.filter(b => b != checkbox.value)
                    }
                    this.bookmarksFormValue = this.bookmarksId.join()
                }
            }))
        })
    </script>
</x-layout>