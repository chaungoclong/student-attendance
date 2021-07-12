<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;

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
}
