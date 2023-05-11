<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>{{ $title . ' - Bookmark Manager' }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
</head>

<body class="text-gray-800 relative h-full selection:bg-gray-900 selection:text-gray-50" x-data="{ open: false }">

    <div class="container max-w-4xl py-16 flex items-center justify-between gap-4">
        <a class="text-xl font-medium hover:underline"
            href="@auth {{ route('bookmarks.index') }} @else {{ route('home') }} @endauth">
            Bookmark Manager
        </a>

        <div class="flex items-center gap-4">
            @auth
                <form action="{{ route('search') }}" method="get" class="grid grid-cols-5">
                    <input type="search" name="q" id="q" placeholder="Search" class="col-span-4 border border-gray-300 focus:border-gray-500 focus:ring-0 rounded-l shadow-sm">
                    <button type="submit" class="bg-gray-950 text-gray-50 flex items-center justify-center shadow-sm rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
            @endauth

            <button class="flex items-center gap-2 py-2 rounded-md transition-colors" x-on:click="open = ! open">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>

    <main class="container max-w-4xl">
        {{ $slot }}
    </main>

    <footer class="container max-w-4xl py-8"></footer>

    <div class="fixed inset-0 bg-white" x-show="open" x-transition.opacity x-cloak>
        <div class="container max-w-4xl my-16 flex items-center justify-between">
            <a class="text-xl font-medium hover:underline"
                href="@auth {{ route('bookmarks.index') }} @else {{ route('home') }} @endauth">
                Bookmark Manager
            </a>

            <button class="flex items-center gap-2 py-2 rounded-md transition-colors" x-on:click="open = ! open">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="text-4xl bg-gray-950 text-gray-50 h-full pt-6" x-on:click.outside="open = false">
            <div class="container max-w-4xl space-y-4">
                @auth
                    <a href="{{ route('profiles.show') }}" class="block py-2 hover:underline">{{ auth()->user()->email }}</a>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="w-full text-left py-2 hover:underline" type="submit">Logout</button>
                    </form>
                @endauth

                @guest
                    <a class="block py-2 hover:underline" href="{{ route('register') }}">Register</a>
                    <a class="block py-2 hover:underline" href="{{ route('login') }}">Login</a>
                @endguest
            </div>
        </div>
    </div>

</body>

</html>
