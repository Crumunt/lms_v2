<?php

namespace App\Helpers;

use Carbon\Carbon;

class AssignmentHelper
{
    /**
     * Get status badge configuration
     */
    public static function getStatusBadge(bool $isSubmitted, Carbon $dueDate): array
    {
        if ($isSubmitted) {
            return [
                'class' => 'bg-green-100 text-green-700',
                'text' => 'Submitted'
            ];
        }

        if ($dueDate->isPast()) {
            return [
                'class' => 'bg-red-100 text-red-700',
                'text' => 'Overdue'
            ];
        }

        if ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 3) {
            return [
                'class' => 'bg-yellow-100 text-yellow-700',
                'text' => 'Due Soon'
            ];
        }

        return [
            'class' => 'bg-gray-100 text-gray-700',
            'text' => 'Not Started'
        ];
    }

    /**
     * Get icon color based on status
     */
    public static function getIconColor(bool $isSubmitted, Carbon $dueDate): string
    {
        if ($isSubmitted) {
            return 'bg-green-100 text-green-600';
        }

        if ($dueDate->isPast()) {
            return 'bg-red-100 text-red-600';
        }

        if ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 3) {
            return 'bg-orange-100 text-orange-600';
        }

        return 'bg-blue-100 text-blue-600';
    }

    public static function getHoverColor(bool $isSubmitted, Carbon $dueDate)
    {
        if ($isSubmitted) {
            return 'hover:bg-green-500';
        }

        if ($dueDate->isPast()) {
            return 'hover:bg-red-500';
        }

        if ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 3) {
            return 'hover:bg-orange-500';
        }

        return 'hover:bg-blue-500';
    }

    /**
     * Get border color based on status
     */
    public static function getBorderColor(bool $isSubmitted, Carbon $dueDate): string
    {
        if (!$isSubmitted && $dueDate->isPast()) {
            return 'border-red-300';
        }

        if (!$isSubmitted && ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 3)) {
            return 'border-yellow-300';
        }

        return 'border-gray-200';
    }

    /**
     * Get all assignment styling at once
     */
    public static function getAssignmentStyling(bool $isSubmitted, Carbon $dueDate): array
    {
        return [
            'status' => self::getStatusBadge($isSubmitted, $dueDate),
            'icon_color' => self::getIconColor($isSubmitted, $dueDate),
            'border_color' => self::getBorderColor($isSubmitted, $dueDate),
            'hover_color' => self::getHoverColor($isSubmitted, $dueDate)
        ];
    }

    /**
     * Format due date with human-readable text
     */
    public static function formatDueDate(Carbon $dueDate): string
    {
        return $dueDate->format('M d, Y') . ' (' . $dueDate->diffForHumans() . ')';
    }

    /**
     * Check if assignment is urgent (due within 24 hours)
     */
    public static function isUrgent(Carbon $dueDate): bool
    {
        return !$dueDate->isPast() && $dueDate->diffInHours(now()) <= 24;
    }
}