<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceDetails;
class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function attendanceDetails () {
        return $this->hasMany(AttendanceDetails::class, 'id_attendance');
    }
}
