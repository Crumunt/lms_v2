@props([
    'name' => 'description',
    'value' => '',
    'max' => '255'
])

<div class="relative">
    <textarea id="editor" name="{{ $name }}">{{ old( $name, $value) }}</textarea>
    <p id="charCount" class="text-xs text-gray-500 text-right mt-1">0 / 255</p>
</div>