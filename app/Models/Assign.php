<?php

namespace App\Models;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_grade",
        "id_subject",
        "id_teacher",
        "status",
        "time_done"
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'id_grade');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'id_subject');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'id_assign');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'id_assign');
    }

    public function findAttendanceByDate($createdAt)
    {
        return $this->attendances
                    ->where('created_at', '>=', $createdAt)
                    ->first();
    }

    public function findScheduleByDay($day)
    {
        return $this->schedules->where('day', $day)->first();
    }
}
