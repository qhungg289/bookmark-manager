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
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="text-gray-950 font-nunito relative h-full selection:bg-teal-600 selection:text-gray-50">

    <div class="container max-w-4xl py-16 flex items-center justify-between gap-4">
        <a class="text-4xl font-black hover:underline hover:scale-125 hover:rotate-6 bg-teal-500 text-gray-50 rounded px-4 py-2 transition-all"
            href="@auth {{ route('bookmarks.index') }} @else {{ route('home') }} @endauth">
            B
        </a>

        <div class="flex items-center gap-8">
            @guest
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            @endguest

            @auth
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.index') }}" class="hover:underline">Admin</a>
                @endif
                <a href="{{ route('profiles.show', ['user' => auth()->user()]) }}" class="hover:underline">Profile</a>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="hover:underline">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </div>

    <main class="container max-w-4xl">
        {{ $slot }}
    </main>

    <footer class="container max-w-4xl py-8"></footer>

</body>

</html>
