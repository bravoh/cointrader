<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use URL;
class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role_id', 'password','status','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getAvatarAttribute($avatar)
    {
        if(file_exists("public/images/users/" . $avatar)) {
            return URL::asset("public/images/users") . '/' . $avatar;
        } else if(file_exists('public/storage/' . $avatar)) {
            return URL::asset('public/storage') . '/' . $avatar;
        } else {
            return URL::asset('public/images/default-user.jpg');
        }
    }

    public function tbcSubscriptions(){
        return $this->hasMany(Subscription::class,'user_id');
    }

    public function getTbcAttribute(){
        if ($this->tbcSubscriptions->count() > 0){
            return true;
        }

        return false;
    }
}
