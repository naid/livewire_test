<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'mobile_number',
        'work_number',
        'home_number',
    ];

    public function users()
    {
        return $this->morphedByMany(User::class, 'contactable');
    }
}
