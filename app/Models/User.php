<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ci',
        'email',
        'password',
        'profile',
        'phone',
        'status',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImagenAttribute()
    {
        if($this->image != null)
        return (file_exists('storage/users/' . $this->image) ? $this->image : 'noimg.jpg');
        else
        return 'noimg.jpg';

                //método 2
                /*
                if($this->image == null)
                {
                if(file_exists('storage/categories/' . $this->image))
                    return $this->image;
                else
                    return 'noimg.jpg';
                } else {
                return 'noimg.jpg';
                }
                */

    }

     // un  usuario (que crea) pued estar en muchas citas
     public function citas()
     {
         return $this->hasMany(Cita::class);
     }
}
