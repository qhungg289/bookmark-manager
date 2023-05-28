<x-layout>
    <x-slot name="title">All users</x-slot>

    <a href="{{ route('admin.index') }}" class="flex items-center gap-1 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <p>Admin</p>
    </a>

    <x-heading>Admin - All users</x-heading>

    <div class="my-8 divide-y divide-gray-200">
        <table class="table-auto border-collapse w-full rounded-md overflow-hidden">
            <thead>
                <tr class="bg-gray-300 text-gray-600">
                    <th class="p-4 border-b border-gray-200 font-bold text-left">Name</th>
                    <th class="p-4 border-b border-gray-200 font-bold text-left">Email</th>
                    <th class="p-4 border-b border-gray-200 font-bold text-right">Joined</th>
                    <th class="p-4 border-b border-gray-200"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="even:bg-gray-100 text-gray-500">
                        <td class="p-4 text-left">
                            <a href="{{ route('profiles.show', ['user' => $user]) }}" class="hover:underline">{{ $user->name }}</a>
                        </td>
                        <td class="p-4 text-left">{{ $user->email }}</td>
                        <td class="p-4 text-right">{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                        <td class="p-4 text-right">
                            @if ($user->role != 'admin')
                                <form action="{{ route('profiles.delete', ['user' => $user]) }}" method="post">
                                    @method('DELETE')
                                    @csrf

                                    <button class="text-red-500" type="submit">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>