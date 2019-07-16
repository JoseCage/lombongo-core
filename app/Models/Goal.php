<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidTrait as Uuids;

class Goal extends Model
{
    use Uuids;

    protected $fillable = [
        'title', 'description', 'due_date', 'user_id'
    ];

    protected $hidden = [];
}
