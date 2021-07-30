<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class AttendanceDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function attendance () {
        return belongsTo(Attendance::class, 'id_attendance');
    }
}
