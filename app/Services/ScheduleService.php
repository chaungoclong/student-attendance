<?php

namespace App\Services;

use App\Models\Grade;
use App\Models\Assign;
use App\Models\Schedule;
use App\Models\Lesson;
/**
 *
 */
class ScheduleService
{
    protected $class_room_time = 8.0;
	/**
	 * [search description]
	 * @param  [type] $request    [description]
	 * @param  [type] $rowPerPage [description]
	 * @return [type]             [description]
	 */

    public function getSubjectsForSchedule($grade) {
        $assigns = Assign::where('id_grade', $grade)
        ->where('status', 1)
        ->get();
        $subjects = [];
        foreach ($assigns as $assign) {
            if (!in_array($assign->subject, $subjects)) {
                $subjects[] = $assign->subject;
            }
        }
        return $subjects;
    }

    public function getTeacherForSchedule($grade, $subject) {
        $assigns = Assign::where('id_grade', $grade)
        ->where('id_subject', $subject)
        ->where('status', 1)
        ->get();
        $teachers = [];
        foreach($assigns as $assign) {
            $teachers[] = $assign->teacher;
        }
        return $teachers;
    }

    public function getAssign($id_grade, $id_subject, $id_teacher) {
        return Assign::where('id_grade', $id_grade)
                ->where('id_subject', $id_subject)
                ->where('id_teacher', $id_teacher)
                ->first();
    }

    public function getDays($id_class_room) {
        $data = [];
        for ($i=1; $i<7; $i++) {
            $schedules = Schedule::where('day_finish', null)
            ->where('id_class_room', $id_class_room)
            ->where('day', $i)
            ->get();
            $timeOfDay = 0.0;
            foreach($schedules as $schedule) {
                $start = $schedule->lesson->start;
                $end = $schedule->lesson->end;
                $timeOfDay += (float)$end - (float)$start;
            }

            if ($timeOfDay < $this->class_room_time) {
                $data[] = $i;
            }
        }

        if (!empty($data)) {
             return response()->json($data);
        } else {
            return false;
        }
    }

    public function getLessons($id_class_room, $day) {
       $schedules = Schedule::where('day_finish', null)
        ->where('id_class_room', $id_class_room)
        ->where('day', $day)
        ->get();

        $idLessonInSchedule = [];
        foreach($schedules as $schedule) {
            $idLessonInSchedule[] = $schedule->id_lesson;
        }

        $lessons = Lesson::whereNotIn('id', $idLessonInSchedule)
        ->get();

        if (!empty($lessons)) {
            return response()->json($lessons);
        } else {
            return false;
        }
    }

    public function storeRepeat($request) {
        $id_assign = $request->id_assign;
        $id_class_rooms = $request->id_class_room;
        $days = $request->day;
        $id_lessons = $request->id_lesson;

        for ($i = 0; $i < count($id_class_rooms); $i++) {
           $row = [
                'id_assign' => $id_assign,
                'id_class_room' => $id_class_rooms[$i],
                'day' => $days[$i],
                'id_lesson' => $id_lessons[$i],
                'day_finish' => NULL
            ];

            Schedule::create($row);
        }
    }

    public function validateSchedule($request) {
        $id_assign = $request->id_assign;
        $id_class_rooms = $request->id_class_room;
        $days = $request->day;
        $id_lessons = $request->id_lesson;

        $errorRows = [];
        $result = [];
        for ($i = 0; $i < count($id_class_rooms); $i++) {
           $row = [
                'id_assign' => $id_assign,
                'id_class_room' => $id_class_rooms[$i],
                'day' => $days[$i],
                'id_lesson' => $id_lessons[$i],
                'day_finish' => NULL
            ];

            if (!$this->checkSchedule($row)) {
                $errorRows[] = $i;
            }
        }

        if (!empty($errorRows)) {
            $result['message'] = 'already exist';
            $result['errorRows'] = $errorRows;
            $result['code'] = 1;
        }

        return $result;
    }

    public function checkSchedule($schedule) {
        $teacher = $this->getTeacherByIdAssign($schedule['id_assign']);
        $assigns = $this->getAssignsByIdTeacher($teacher->id);
        $id_assigns = [];
        foreach($assigns as $assign) {
            $id_assigns[] = $assign->id;
        }
        $day = $schedule['day'];
        $allSchedulesTeacherOfDay = $this->getSchedulesOfTeacher($id_assigns, $day);
        $allSchedulesClassRoomOfDay = $this->getScheduleOfClassRoom($schedule['id_class_room'], $day);
        $allLessonToCheckOfDay = [];
        $lessonNeedCheck = $this->getLessonById($schedule['id_lesson']);

        foreach($allSchedulesTeacherOfDay as $scheduleTeacher) {
            $allLessonToCheckOfDay[] = $scheduleTeacher->lesson;
        }

        foreach($allSchedulesClassRoomOfDay as $scheduleClassRoom) {
            if (!in_array($scheduleClassRoom->lesson, $allLessonToCheckOfDay)) {
                $allLessonToCheckOfDay[] = $scheduleClassRoom->lesson;
            }
        }
        return $this->checkLessonInDay($allLessonToCheckOfDay, $lessonNeedCheck);
    }

    public function getSchedulesOfTeacher($id_assigns, $day) {
        return Schedule::where('day_finish',NULL)
                ->whereIn('id_assign', $id_assigns)
                ->where('day', $day)
                ->get();
    }

    public function getScheduleOfClassRoom($id_class_room, $day) {
        return Schedule::where('day_finish',NULL)
                ->where('id_class_room', $id_class_room)
                ->where('day', $day)
                ->get();
    }

    public function checkLessonInDay($input, $lessonNew) {
        foreach ($input as $value) {
            if (((float)$lessonNew->start >= (float)$value->start && (float)$lessonNew->start < (float)$value->end)
                || ((float)$lessonNew->end <= (float)$value->end && (float)$lessonNew->end > (float)$value->start)
                || ((float)$lessonNew->start < (float)$value->start && (float)$lessonNew->end > (float)$value->end)
            ) {
                return false;
            }
        }
        return true;
    }

    public function checkLessonUpdateSameClassAndDay($oldLesson, $newLesson) {
        return (float)$newLesson->start >= (float)$oldLesson->start && (float)$newLesson->end <= (float)$oldLesson->end;
    }
    public function getTeacherByIdAssign($id_assign) {
        $assign = Assign::find($id_assign);

        return $assign->teacher;
    }

    public function getAssignsByIdTeacher($id_teacher) {
        return Assign::where('id_teacher', $id_teacher)
                ->get();;
    }

    public function getLessonById($id_lesson) {
        return Lesson::find($id_lesson);
    }
}
