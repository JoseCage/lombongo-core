<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Auto generate a uuid to the given model.
*/
trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
            }
        );
    }
}
