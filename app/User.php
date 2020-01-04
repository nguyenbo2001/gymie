<?php

namespace App;

use Auth;
use Lubus\Constants\Status;
use Illuminate\Auth\Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasMedia/* , HasMediaConversions */
{
    use Notifiable;

    use Authenticatable, CanResetPassword, EntrustUserTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Default Values
     */
    protected $attributes = [
        'name' => '',
        'email' => '',
        'status' => 0,
    ];

    public $registerMediaConversionsUsingModelInstance = true;

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->height(50)
            ->width(50)
            ->sharpen(10)
            // ->withManipulations(['w' => 50, 'h' => 50, 'q' => 100, 'fit' => 'crop'])
            ->performOnCollections('staff');

        $this->addMediaConversion('form')
            ->height(70)
            ->width(70)
            ->sharpen(10)
            // ->withManipulations(['w' => 70, 'h' => 70, 'q' => 100, 'fit' => 'crop'])
            ->performOnCollections('staff');
    }

    public function scopeExcludeArchive($query)
    {
        if (Auth::User()->id != 1) {
            return $query->where('status', '!=', \constStatus::Archive)
                ->where('id', '!=', 1);
        }

        return $query->where('status', '!=', \constStatus::Archive);
    }

    public function role_user()
    {
        return $this->hasOne('App\RoleUser');
    }
}
