<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title . ' - Bookmark Manager' }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
</head>

<body class="text-slate-800 relative h-full">

    <div class="container max-w-4xl py-16 flex flex-col md:flex-row gap-4 justify-between">
        <a class="text-xl font-medium hover:underline" href="/">Bookmark Manager</a>

        @guest
            <div class="flex gap-2">
                <a class="px-4 py-2 border border-slate-300 hover:border-slate-500 rounded-md transition-colors"
                    href="{{ route('register') }}">Register</a>
                <a class="px-4 py-2 border border-slate-300 hover:border-slate-500 rounded-md transition-colors"
                    href="{{ route('login') }}">Login</a>
            </div>
        @endguest

        @auth
            <div class="relative" x-data="{ open: false }">
                <button class="w-full flex items-center gap-2 px-4 py-2 border rounded-md transition-colors"
                    x-bind:class="open ? 'border-slate-800 bg-slate-800 text-slate-50' : 'border-slate-300 hover:border-slate-500'"
                    x-on:click="open = ! open">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Profile</span>
                </button>

                <div x-show="open" x-transition x-cloak
                    class="absolute top-12 right-0 w-full md:min-w-fit divide-y divide-slate-300 rounded-md bg-white border border-slate-300 shadow-md"
                    x-on:click.outside="open = false">
                    <a href="" class="block px-4 py-2 hover:underline">{{ auth()->user()->email }}</a>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:underline" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>

    <main class="container max-w-4xl">
        {{ $slot }}
    </main>

</body>

</html>
