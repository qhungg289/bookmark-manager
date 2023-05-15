<x-layout>
    <x-slot name="title">Register</x-slot>

    <x-heading>Register</x-heading>

    <form action="" method="post" class="my-4 flex flex-col gap-3">
        @csrf

        <div class="flex flex-col">
            <x-forms.label for="name">Name</x-forms.label>
            <x-forms.input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="John Doe" />
            @error('name')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex flex-col">
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@example.com" />
            @error('email')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div class="flex flex-col">
                <x-forms.label for="password">Password</x-forms.label>
                <x-forms.input type="password" name="password" id="password" placeholder="Minimum 8 characters" />
                @error('password')
                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-forms.label for="password_confirmation">Confirm password</x-forms.label>
                <x-forms.input type="password" name="password_confirmation" id="password_confirmation" />
                @error('password_confirmation')
                    <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <button
            class="w-fit bg-teal-600 text-gray-50 px-6 py-3 rounded-md hover:opacity-80 transition-all" type="submit">
            Register
        </button>
    </form>
</x-layout>
