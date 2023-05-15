@props(['type' => 'text', 'name', 'id', 'value' => null, 'placeholder' => null])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="mt-1 bg-gray-100 border-0 border-b-2 border-transparent outline-none focus:ring-0 focus:border-teal-400 rounded transition-all placeholder:text-gray-400" {{ $attributes }}>