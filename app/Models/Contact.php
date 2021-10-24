<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function users()
    {
        return $this->morphedByMany(User::class, 'addressable');
    }
}
