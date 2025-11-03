<?php

namespace App\Helpers;

class AdminUserHelper
{
    /**
     * Get badge class based on user status
     */
    public static function getStatusBadgeClass(?string $status): string
    {
        return match($status) {
            'active' => 'badge-success',
            'inactive' => 'badge-secondary',
            'deactivated' => 'badge-danger',
            'pending' => 'badge-warning',
            default => 'badge-secondary',
        };
    }

    /**
     * Get full badge HTML with styling
     */
    public static function getStatusBadge(?string $status): array
    {
        return match($status) {
            'active' => [
                'class' => 'bg-green-100 text-green-800',
                'text' => 'Active',
                'icon' => 'fa-check-circle'
            ],
            'inactive' => [
                'class' => 'bg-gray-100 text-gray-800',
                'text' => 'Inactive',
                'icon' => 'fa-minus-circle'
            ],
            'deactivated' => [
                'class' => 'bg-red-100 text-red-800',
                'text' => 'Deactivated',
                'icon' => 'fa-ban'
            ],
            'pending' => [
                'class' => 'bg-yellow-100 text-yellow-800',
                'text' => 'Pending',
                'icon' => 'fa-clock'
            ],
            default => [
                'class' => 'bg-gray-100 text-gray-800',
                'text' => 'Unknown',
                'icon' => 'fa-question-circle'
            ],
        };
    }

    /**
     * Get text color class based on status
     */
    public static function getStatusTextClass(?string $status): string
    {
        return match($status) {
            'active' => 'text-green-600',
            'inactive' => 'text-gray-600',
            'deactivated' => 'text-red-600',
            'pending' => 'text-yellow-600',
            default => 'text-gray-600',
        };
    }

    /**
     * Get background color class based on status
     */
    public static function getStatusBgClass(?string $status): string
    {
        return match($status) {
            'active' => 'bg-green-50',
            'inactive' => 'bg-gray-50',
            'deactivated' => 'bg-red-50',
            'pending' => 'bg-yellow-50',
            default => 'bg-gray-50',
        };
    }

    /**
     * Get border color class based on status
     */
    public static function getStatusBorderClass(?string $status): string
    {
        return match($status) {
            'active' => 'border-green-200',
            'inactive' => 'border-gray-200',
            'deactivated' => 'border-red-200',
            'pending' => 'border-yellow-200',
            default => 'border-gray-200',
        };
    }

    /**
     * Get status label/text
     */
    public static function getStatusLabel(?string $status): string
    {
        return match($status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'deactivated' => 'Deactivated',
            'pending' => 'Pending',
            default => 'Unknown',
        };
    }

    /**
     * Check if status is active
     */
    public static function isActive(?string $status): bool
    {
        return $status === 'active';
    }

    /**
     * Check if status needs attention
     */
    public static function needsAttention(?string $status): bool
    {
        return in_array($status, ['pending', 'deactivated']);
    }
}