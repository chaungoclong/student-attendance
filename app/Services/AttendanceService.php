<?php 

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Assign;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Teacher;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
class AttendanceService
{
	public function getView(Request $request, Teacher $teacher)
	{
		// request ajax : get subject & get students
		if ($request->ajax()) {
			// check action
			$action = $request->action ?? '';

			switch ($action) {
				case 'get_subject':
					if (! isset($request->id_grade)) {
						throw new NotFoundException('Miss Data');
					}

					$idGrade = $request->id_grade;

					$subjects = $teacher->getMySubjects(1, $idGrade);

					return response()->json(['subjects' => $subjects], 200);
					break;

				case 'get_student':
					if (! (isset($request->id_grade) 
						&& isset($request->id_subject))) {
						throw new NotFoundException('Miss Data');
					}

					$idGrade = $request->id_grade;
					$idSubject = $request->id_subject;
					$idTeacher = $teacher->id;

					return $this->getStudents($idGrade, $idSubject, $idTeacher);
					break;
				
				default:
					throw new NotFoundException("Not Found Action");
					break;
			}
		}

		// get grades
		$grades = $teacher->getMyGrades(1);

		return view('teachers.attendances.create')->with('grades', $grades);
	}

	/**
	 * lay danh sach sinh vien cua lop can diem danh
	 * @param  [type] $idGrade   [description]
	 * @param  [type] $idSubject [description]
	 * @param  [type] $idTeacher [description]
	 * @return [type]            [description]
	 */
	public function getStudents($idGrade, $idSubject, $idTeacher)
	{
		$check = $this->check($idGrade, $idSubject, $idTeacher);

		if ($check['status'] == 'error') {
			unset($check['status']);
			return response()->json($check, 422);
		}

		list($assign, $schedule) = $check['data'];

		$grade = Grade::find($idGrade);
		$students = $grade->students;
		$html = view('teachers.attendances.load_create')
				->with('students', $students)
				->render();


		if (count($assign->attendances)) {
			$createdAt = $assign->attendances->last()->created_at;
			$createdAt = date('H:i:s d-m-Y', strtotime($createdAt));
		} else {
			$createdAt = "Chưa điểm danh";
		}
		
		$titleInfo = "Điểm danh môn " . $assign->subject->name . " Lớp " . strtoupper($assign->grade->name . $assign->grade->yearschool->name);
		if ($assign->teacher->gender == "Nam") {
			$titleInfo .= ' Thầy ' . $assign->teacher->name;
		} else {
			$titleInfo .= ' Cô ' . $assign->teacher->name;
		}

		return response()->json([
			'html' => $html,
			'time_done' => $assign->time_done,
			'created_at' => $createdAt,
			'totalTime' => $assign->subject->duration,
			'title_info' => $titleInfo
		], 200);
	}

	/**
	 * Lưu điểm danh vào database
	 * @param  Request $request [description]
	 * @param  Teacher $teacher [description]
	 * @return [type]           [description]
	 */
	public function save(Request $request, Teacher $teacher)
	{
		if (! (isset($request->id_grade) && isset($request->id_subject) 
				&& isset($request->data))) {
			throw new NotFoundException('Miss data');
		}

		// data
		$idGrade = $request->id_grade;
		$idSubject = $request->id_subject;
		$idTeacher = $teacher->id;
		$data = json_decode($request->data);
		$notePrimary = $request->note_primary; 

		// check data
		$check = $this->check($idGrade, $idSubject, $idTeacher);
		if ($check['status'] == 'error') {
			unset($check['status']);
			return response()->json($check, 422);
		}

		// result after check if have not error
		list($assign, $schedule) = $check['data'];

		try {
			$currentTime = date('Y-m-d H:i:s');
			$time = $schedule->lesson->time;

			// add attendance list
			$attendance = Attendance::create([
				'id_assign' => $assign->id,
				'time' => $time,
				'note' => $notePrimary,
				'created_at' => $currentTime
			]);
			
			// add attendance record
			$idAttendance = $attendance->id;
			
			foreach ($data as $key => $value) {
				$row = [
					'id_attendance' => $idAttendance,
					'id_student' => $value->id_student,
					'status' => $value->status,
					'note' => $value->note
				];

				AttendanceDetail::create($row);
			}

			// cap nhat thoi gian da day trong phan cong va cap nhat trang thai da day xong neu so gio da day = so gio dinh muc
			$oldTimeDone = $assign->time_done;
			$newTimeDone = (float)$oldTimeDone + (float)$time;

			$asignStatus = $assign->status;
			if ((float)$assign->subject->duration === $newTimeDone) {
				$asignStatus = 2;
			}

			$assign->update([
				'time_done' => $newTimeDone,
				'status' => $asignStatus
			]);
		} catch (\Exception $e) {
			return response()
					->json(['message' => 'co loi khi them diem danh'], 422);
		}

		return response()->json([
			'created_at' => date('H:i:s d-m-Y', strtotime($currentTime)),
			'time_done' => $newTimeDone,
			'totalTime' => $assign->subject->duration
		], 200);
	}

	/**
	 * kiem tra truoc khi tra ve danh sach sinh vien || them diem danh
	 * @param  [type] $idGrade   [description]
	 * @param  [type] $idSubject [description]
	 * @param  [type] $idTeacher [description]
	 * @return [type]            [description]
	 */
	public function check($idGrade, $idSubject, $idTeacher)
	{
		$currentDate = date('Y-m-d');
		$currentDay = date('N');

		$assign = $this->getAssign($idGrade, $idSubject, $idTeacher);
		// khong co phan cong
		if ($assign === null) {
			return [
				'status' => 'error',
				'message' => 'ban khong day mon nay o lop nay'
			];
		}

		$schedule = $assign->findScheduleByDay($currentDay);
		// khong dung ngay (khong co lich hoc hom nay)
		if ($schedule === null) {
			return [
				'status' => 'error',
				'message' => 'hom nay lop nay khong hoc mon nay'
			];
		}

		// kiem tra da diem danh
		if ($this->isCreated($assign->id, $currentDate)) {
			$createdAt = $assign->attendances->last()->created_at;
			$createdAt = date('H:i:s d-m-Y', strtotime($createdAt));
			return [
				'status' => 'error',
				'message' => 'Hôm nay bạn đã điểm danh',
				'time_done' => $assign->time_done,
				'created_at' => $createdAt,
				'totalTime' => $assign->subject->duration
			];
		}

		return [
			'status' => 'success',
			'data' => [$assign, $schedule]
		];
	}

	/**
	 * lay object diem danh (assign) tu id_grade, id_subject, id_teacher
	 * @param  [type] $idGrade   [description]
	 * @param  [type] $idSubject [description]
	 * @param  [type] $idTeacher [description]
	 * @return [type]            [description]
	 */
	public function getAssign($idGrade, $idSubject, $idTeacher)
	{
		return Assign::where('id_grade', $idGrade)
					    ->where('id_subject', $idSubject)
					    ->where('id_teacher', $idTeacher)
					    ->first();
	}

	/**
	 * lay lich hoc theo id phan cong va thu(thu hai, thu ba ...)
	 * can use: $assign->findScheduleByDay($day)
	 * @param  [type] $idAssign [description]
	 * @param  [type] $day      [description]
	 * @return [type]           [description]
	 */
	public function getSchedule($idAssign, $day)
	{
		return Schedule::where('id_assign', $idAssign)
					    ->where('day', $day)
					    ->first();
	}

	/**
	 * kiem tra da diem danh cua mot lop tai mot mon hay chua
	 * can use: return $assign->findAttendanceByDate($date)
	 * @param  [type]  $idAssign [description]
	 * @param  [type]  $time     [description]
	 * @return boolean           [description]
	 */
	public function isCreated($idAssign, $time)
	{
		$count = DB::table('attendances')
					->where('id_assign', $idAssign)
					->whereRaw('DATE(created_at) = ?', [$time])
					->count();

		return $count > 0 ? true : false;
	}
}