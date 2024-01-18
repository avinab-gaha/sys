<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Illuminate\Foundation\Auth\User as Authenticatable;


class SysUser extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password'];

}
