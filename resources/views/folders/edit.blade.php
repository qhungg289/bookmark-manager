<x-layout>
    <x-slot name="title">Edit {{ $folder->name }}</x-slot>

    <h1 class="text-4xl font-bold">Edit {{ $folder->name }}</h1>

    <form action="{{ route('folders.update', ['folder' => $folder] ) }}" method="post" class="mt-8 flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2">
            <div class="flex flex-col">
                <label class="font-medium text-gray-600" for="name">Name</label>
                <small class="text-xs text-gray-400">Required</small>
            </div>
            <div class="flex flex-col">
                <input class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm" type="text" name="name" id="name" value="{{ old('name', $folder->name) }}">
                @error('name')
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
                    x-data="{ isChecked: @if (boolval($folder->is_public)) {{ "true" }} @else {{ "false" }} @endif }"
                    for="is_public"
                    class="relative h-8 w-14 cursor-pointer"
                >
                    <input
                        x-model="isChecked"
                        type="checkbox"
                        id="is_public"
                        name="is_public"
                        class="peer sr-only"
                        @checked(boolval($folder->is_public))
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

        <div class="grid grid-cols-2">
            <div class="flex flex-col">
                <label class="font-medium text-gray-600" for="bookmarks">Bookmarks</label>
            </div>
            <div class="border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm px-4 h-56 overflow-auto" x-data="bookmarks">
                <input type="hidden" name="bookmarks" x-bind:value="bookmarksFormValue">

                @foreach ($folder->bookmarks as $bookmark)
                    <div class="flex items-center gap-2">
                        <input class="rounded text-gray-800 p-2 border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400" type="checkbox" checked value="{{ $bookmark->id }}" x-on:change="handleCheck($el)" x-init="handleCheck($el)">
                        <span class="flex items-center gap-2 my-4 group">
                            <img class="w-5" src="{{ $bookmark->icon }}" alt="">
                            <span class="truncate max-w-[30ch] relative">
                                {{ $bookmark->name }}
                            </span>
                        </span>
                    </div>
                @endforeach

                @foreach ($bookmarks as $bookmark)
                    <div class="flex items-center gap-2">
                        <input class="rounded text-gray-800 p-2 border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400" type="checkbox" value="{{ $bookmark->id }}" x-on:change="handleCheck($el)">
                        <span class="flex items-center gap-2 my-4 group">
                            <img class="w-5" src="{{ $bookmark->icon }}" alt="">
                            <span class="truncate max-w-[30ch] relative">
                                {{ $bookmark->name }}
                            </span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button class="basis-1/6 py-2 px-4 rounded border border-gray-950 bg-gray-950 text-gray-50 shadow-sm" type="submit">Save</button>
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