<x-layout>
    <x-slot name="title">Login</x-slot>

    <h1 class="text-4xl font-bold">Login</h1>

    <form action="" method="post" class="my-4 flex flex-col gap-3">
        @csrf

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="email">Email</label>
            <input
                class="mt-1 border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm"
                type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@example.com">
            @error('email')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="password">Password</label>
            <input
                class="mt-1 border border-gray-300 focus:border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 rounded shadow-sm"
                type="password" name="password" id="password">
            @error('password')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex items-center gap-1">
            <input
                class="rounded text-gray-800 border-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 shadow-sm"
                type="checkbox" name="remember" id="remember">
            <label class="font-medium text-gray-600" for="remember">Remember me</label>
        </div>

        <button
            class="bg-gray-950 hover:bg-transparent text-gray-50 hover:text-gray-950 font-medium p-4 rounded border border-gray-950 transition-colors"
            type="submit">Login</button>
    </form>
</x-layout>
