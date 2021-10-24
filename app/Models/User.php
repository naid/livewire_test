<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'company_name',
        'company_email',

    ];
    
    protected static $logAttributes = [
        'first_name',
        'last_name',
        'email',
        'password',
        'company_name',
        'company_email',

    ];

    //LOGGING everything when there's a change in the table
    //protected static $recordEvents = [ 'updated' ]; //logging only updates to data
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function contacts()
    {
        return $this->morphToMany(Contact::class, 'contactable');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    protected static function bootActionableTrait()
    {
        self::deleting(function ($model) {
            $model->addresses()->delete();
            $model->contacts()->delete();
        });
    }
}
