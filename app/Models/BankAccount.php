<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidTrait as Uuids;

class BankAccount extends Model
{
    use Uuids;

    protected $fillable = [
        'account_name', 'description', 'bank_id'
    ];

    protected $hidden = [];
}
