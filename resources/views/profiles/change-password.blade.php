<x-layout>
    <x-slot name="title">Change password</x-slot>

    <x-heading>Change password</x-heading>

    <form action="{{ route('profiles.update-password', ['user' => $user]) }}" method="post" class="my-4 flex flex-col gap-3">
        @csrf
        @method('PUT')

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="current_password">Current password</label>
            <x-forms.input type="password" name="current_password" id="current_password" />
            @error('current_password')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="new_password">New password</label>
            <x-forms.input type="password" name="new_password" id="new_password" />
            @error('new_password')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-medium text-gray-600" for="new_password_confirmation">New password confirmation</label>
            <x-forms.input type="password" name="new_password_confirmation" id="new_password_confirmation" />
            @error('new_password_confirmation')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <button class="w-fit bg-teal-600 text-gray-50 px-6 py-3 rounded-md hover:opacity-80 transition-all"
            type="submit">Update</button>
    </form>
</x-layout>