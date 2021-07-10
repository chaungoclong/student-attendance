<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'id_grade'
    ];

    protected $hidden = ['password', 'remember_token'];

    // cast geder to string
    public function getGenderAttribute($value)
    {
        return $value ? "Nam" : "Nữ";
    }

    public function grade()
    {
        // dd($this->belongsTo(Grade::class));
        return $this->belongsTo(Grade::class, 'id_grade');   
    }
}
