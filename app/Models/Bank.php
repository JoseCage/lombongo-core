<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidTrait as Uuids;

class Bank extends Model
{
    use uuids;

    protected $fillable = [
        'name', 'bank_logo', 'description'
    ];

    protected $hidden = [];
}
