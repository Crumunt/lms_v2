<?php

namespace App;

use Illuminate\Support\Str;

trait HasUuid
{
    //
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            // Automatically assign UUID if the primary key is empty
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Disable auto-incrementing since we're using UUIDs.
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Set the key type to string for UUIDs.
     */
    public function getKeyType()
    {
        return 'string';
    }
}
