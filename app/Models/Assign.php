<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_grade",
        "id_subject",
        "id_teacher",
        'status'
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
}
