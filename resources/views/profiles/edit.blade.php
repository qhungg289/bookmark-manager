<x-layout>
    <x-slot name="title">Update profile</x-slot>

    <x-heading>Update profile</x-heading>

    <form action="{{ route('profiles.update', ['user' => $user]) }}" method="post" class="my-4 flex flex-col gap-3">
        @csrf
        @method('PUT')

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="name">Name</label>
            <x-forms.input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="John Doe" />
            @error('name')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="email">Email</label>
            <x-forms.input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="email@example.com" />
            @error('email')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <button class="w-fit bg-teal-600 text-gray-50 px-6 py-3 rounded-md hover:opacity-80 transition-all"
            type="submit">Update</button>
    </form>
</x-layout>