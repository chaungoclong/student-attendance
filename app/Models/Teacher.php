<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $guard = 'teacher';

    protected $fillable = ['email', 'password'];

    protected $hidden = ['password', 'remember_token'];
}
