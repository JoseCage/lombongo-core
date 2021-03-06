<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidTrait as Uuids;

class Category extends Model
{
    use Uuids;

    protected $fillable = [
        'name', 'description', 'category_icon'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
