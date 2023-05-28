<x-layout>
    <x-slot name="title">Admin</x-slot>

    <x-heading>Admin</x-heading>

    <div class="grid md:grid-cols-2 gap-4 mt-8">
        <a href="{{ route('admin.bookmarks') }}" class="p-4 h-fit rounded-md bg-orange-400 text-white hover:opacity-80 transition-all">
            <p>Bookmarks</p>
            <p class="text-4xl font-bold mt-2">{{ $bookmarksCount }}</p>

            <div class="bg-white mt-4 rounded">
                {!! $bookmarksChart->renderHtml() !!}
            </div>
        </a>

        <a href="{{ route('admin.folders') }}" class="p-4 h-fit rounded-md bg-green-400 text-white hover:opacity-80 transition-all">
            <p>Folders</p>
            <p class="text-4xl font-bold mt-2">{{ $foldersCount }}</p>

            <div class="bg-white mt-4 rounded">
                {!! $foldersChart->renderHtml() !!}
            </div>
        </a>

        <a href="{{ route('admin.users') }}" class="p-4 h-fit rounded-md bg-blue-400 text-white hover:opacity-80 transition-all">
            <p>Users</p>
            <p class="text-4xl font-bold mt-2">{{ $usersCount }}</p>

            <div class="bg-white mt-4 rounded">
                {!! $usersChart->renderHtml() !!}
            </div>
        </a>

        <a href="{{ route('admin.tags') }}" class="p-4 h-fit rounded-md bg-fuchsia-400 text-white hover:opacity-80 transition-all">
            <p>Tags</p>
            <p class="text-4xl font-bold mt-2">{{ $tagsCount }}</p>

            <div class="bg-white mt-4 rounded">
                {!! $tagsChart->renderHtml() !!}
            </div>
        </a>
    </div>

    {!! $bookmarksChart->renderChartJsLibrary() !!}
    {!! $bookmarksChart->renderJs() !!}
    {!! $foldersChart->renderJs() !!}
    {!! $usersChart->renderJs() !!}
    {!! $tagsChart->renderJs() !!}
</x-layout>