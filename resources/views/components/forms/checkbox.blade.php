@props(['name', 'id', 'value' => null])

<input class="rounded bg-gray-100 text-teal-600 border-none outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-400 transition-all" type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" {{ $attributes }}>