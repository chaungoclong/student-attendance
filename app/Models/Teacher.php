<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $guard = 'teacher';

    protected $fillable = [
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'status'
    ];

    protected $hidden = ['password', 'remember_token'];

    // cast geder to string
    public function getGenderAttribute($value)
    {
        return $value ? "Nam" : "Nữ";
    }

    // convert Y-m-d to d-m-Y when get dob Attribute
    public function getDobAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)
                      ->format('d-m-Y');
    }

    // convert d-m-Y to Y-m-d when set dob Attribute
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value)
                                          ->format('Y-m-d');
    }
}
