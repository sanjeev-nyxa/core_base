<?php

namespace Labs\Core\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Labs\Core\Entities\Traits\UuidModelTrait;
use Labs\Core\Notifications\ResetPasswordNotification;
use Labs\Core\Notifications\ResetPasswordNotificationAdmin;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class BaseUser
 * Labs\Core\Entities
 */
class BaseUser extends Authenticatable implements HasMedia
{
    use UuidModelTrait, Notifiable, HasRoles, HasApiTokens, HasMediaTrait;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'user_id', 'mobile_number', 'phone_number',
        'position', 'bio', 'gender', 'lang', 'first_name', 'last_name', 'avatar'
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
     * @param $query
     * @return mixed
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
            return $q->where('name', 'Admin');
        });
    }


    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        if ($this->hasRole('Admin')) {
            $this->notify(new ResetPasswordNotificationAdmin($token));
        } else {
            $this->notify(new ResetPasswordNotification($token));
        }
    }

    /**
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'notifications_' . $this->id;
    }

}