@props([
    'icon' => 'fas fa-chart-line',
    'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-600',
    'value' => '0',
    'label' => 'Stat Label',
    'trend' => 'up', // up, down, neutral
    'trendValue' => '0%',
    'description' => ''
])

<div class="stat-card">
    <div class="stat-icon {{ $iconBg }} text-white">
        <i class="{{ $icon }}"></i>
    </div>
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-2xl font-bold text-gray-800">{{ $value }}</h3>
        @if($trend !== 'neutral')
            <div class="flex items-center {{ $trend === 'up' ? 'text-green-600' : 'text-red-600' }}">
                <i class="fas fa-arrow-{{ $trend === 'up' ? 'up' : 'down' }} text-xs mr-1"></i>
                <span class="text-sm font-medium">{{ $trendValue }}</span>
            </div>
        @endif
    </div>
    <p class="text-gray-500 text-sm mb-2">{{ $label }}</p>
    @if($description)
        <p class="text-gray-400 text-xs mb-3">{{ $description }}</p>
    @endif
</div>
