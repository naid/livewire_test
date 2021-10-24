<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Address extends Model
{
    use LogsActivity;

    protected $fillable = [
        'address1',
        'address2',
        'suburb',
        'post_code',
        'city',
    ];

    protected static $logAttributes = [
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
