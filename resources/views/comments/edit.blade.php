<x-layout>
    <x-slot name="title">Edit comment</x-slot>

    <x-heading>Edit comment</x-heading>

    <form action="{{ route('comments.update', ['comment' => $comment]) }}" method="post" class="mt-8 flex flex-col gap-3">
        @csrf
        @method('PUT')

        <div class="flex flex-col">
            <x-forms.input type="text" name="comment" id="comment" placeholder="Comment..." value="{{ old('comment', $comment->content) }}" />
            @error('comment')
                <small class="mt-1 text-sm text-rose-600">{{ $message }}</small>
            @enderror
        </div>

        <button class="w-fit bg-teal-600 text-gray-50 px-6 py-3 rounded-md hover:opacity-80 transition-all" type="submit">Save</button>
    </form>
</x-layout>