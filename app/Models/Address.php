<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address1',
        'address2',
        'suburb',
        'post_code',
        'city',
    ];

    public function users()
    {
        return $this->morphedByMany(User::class, 'addressable');
    }
}
