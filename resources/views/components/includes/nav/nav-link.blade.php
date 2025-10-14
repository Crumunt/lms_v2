@props([
    'route' => null,
    'navTitle' => 'default',
])

<a href="{{ route($route) }}"
    class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2">
    {{ $iconSlot }}
    <span>{{ $navTitle }}</span>
</a>