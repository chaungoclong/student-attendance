@extends('layouts.app')

@section('title', __('Teacher'))

@section('name_page', 'Attendance')

@section('content')

<div class="card">
	<div class="card-header" data-background-color="green">
		<h4 id="titleInfo" class="text-center" style="height: 30px;"></h4>
	</div>
	<div class="card-content">

	<div class="card-title" style="display: flex; justify-content: center; align-items: center;"> 

		{{-- select grade --}}
		<div class="col-lg-4col-md-4 col-sm-4">
			<select class="selectpicker" data-style="select-with-transition" title="Choose Grade" data-size="7" id="grade">
				<option value disabled> Choose Grade</option>
				@foreach ($grades as $grade)
					<option value="{{ $grade->id }}">
						{{ $grade->name . $grade->yearSchool->name }}
					</option>
				@endforeach
			</select>
		</div>

		{{-- select subject --}}
		<div class="col-lg-4 col-md-4 col-sm-4">
			<select class="selectpicker" data-style="select-with-transition" title="Choose Subject" data-size="7" id="subject" disabled>
				<option value disabled> Choose Subject</option>
				<option value="">All</option>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>

		{{-- select subject --}}
		<div class="col-lg-2 col-md-2 col-sm-2" style="display: flex; justify-content: flex-end;">
			<button type="button" class="btn btn-warning btn-round">History</button>
		</div>
	</div>

	<form id="attendanceForm">
		<div class="card-title" id="message"></div>
		<div class="card-title row text-center" id="info" style="display: flex; justify-content: center; font-size: 20px; margin-top: 20px; margin-bottom: 20px;">
			<div class="col-md-6" id="timeDone" style="display: flex; justify-content: space-around;"></div>
			<div class="col-md-6" id="lastTime"></div>
		</div>
		<div class="table-responsive">
			<table class="table" id="attendanceTable">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Status</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</form>
</div>
</div>
@stop
@push('script')
<script type="text/javascript">
	$(function() {
		let form = $('#attendanceForm');
		let table = $('#attendanceTable');

		$(table).hide();

		$('[data-toggle="tooltip"]').tooltip();

		// get subjects of grade
		$(document).on('change', '#grade', function() {
			get_subject($(this).val());
			$('#subject').prop('disabled', false);
		});

		// get students of grade
		$(document).on('change', '#subject', function() {
			get_student($('#grade').val(), $(this).val());
		});

		// submit
		$(document).on('click', '#saveBtn', function() {
			let data = {
				_token: '{{ csrf_token() }}',
				data: get_data(),
				id_grade: $('#grade').val(),
				id_subject: $('#subject').val(),
				note_primary: $('#notePrimary').val()
			}
			console.log(data);

			submit(data);
		});
	});

	function get_subject(idGrade) {
		$.ajax({
			url: '{{ route('teacher.attendance.create') }}',
			type: 'GET',
			dataType: 'json',
			data: {id_grade: idGrade, action: 'get_subject'},
			success: (res) => {
				let subjects = res.subjects;
				render_option({
					select: '#subject',
					field: {valueField: 'id', textField: 'name'},
					type: 'fresh',
					data: subjects,
					default: {attr: "disabled", text: 'Choose Subject'}
				});
			},
			error: (res) => {
				let error = res.responseJSON;

				// redirect to 404 page if not found action
				if (error.hasOwnProperty('url')) {
					window.location.replace(error.url);
				}
			}
		});
	}

	function get_student(idGrade, idSubject) {
		$.ajax({
			url: '{{ route('teacher.attendance.create') }}',
			type: 'GET',
			dataType: 'json',
			data: {
				id_grade: idGrade,
				id_subject: idSubject, 
				action: 'get_student'
			},
			success: (res) => {
				console.table(res);
				$('#attendanceTable tbody').html(res.html);

				$('#attendanceTable').show();

				$('#titleInfo').html(res.title_info);

				// so gio da day
				$('#info #timeDone').html(`
				<span>
					Số giờ đã dạy: <strong class="text-danger">${res.time_done}</strong> giờ
				</span> 
				<span>
					Số giờ còn lại: <strong class="text-danger">
					${res.totalTime - res.time_done}</strong> giờ
				</span>`);

				// lan diem danh cuoi
				$('#info #lastTime').html(`
    				<p class="text-center text-info">
    					Lần điểm danh cuối:
    					<span class="text-danger">
    						<strong>${res.created_at}</strong>
    					</span>
    				</p>`);
			},
			error: (res) => {
				let error = res.responseJSON;
				console.log(error);

				$('#titleInfo').html('');

				// redirect to 404 page if not found action
				if (error.hasOwnProperty('url')) {
					window.location.replace(error.url);
				}

				// show error message
				if (error.hasOwnProperty('message')) {
					render_alert('error', error.message, '#message');
					

					$('#attendanceTable').hide();
					// $('#info #lastTime, #info #timeDone').html('');

					// hide alert after time
					hide_after('.alert', 5000);
				}

				// show info
				if (error.hasOwnProperty('time_done') 
					&& error.hasOwnProperty('created_at')
					&& error.hasOwnProperty('totalTime')) {

					// so gio da day
					$('#info #timeDone').html(`
					<span>
						Số giờ đã dạy: <strong class="text-danger">
						${error.time_done}</strong> giờ
					</span> 
					<span>
						Số giờ còn lại: <strong class="text-danger">
						${error.totalTime - error.time_done}</strong> giờ
					</span>`);

					// lan diem danh cuoi
					$('#info #lastTime').html(`
    				<p class="text-center text-info">
    					Lần điểm danh cuối:
    					<span class="text-danger">
    						<strong>${error.created_at}</strong>
    					</span>
    				</p>`);
				}
			}
		});
	}
    
    function submit(data) {
    	$.ajax({
    		url: '{{ route('teacher.attendance.store') }}',
    		data: data,
    		type: 'POST',
    		dataType: 'json',
    		success: (res) => {
    			$('#attendanceTable').hide();

    			// lan diem danh cuoi
    			$('#info #lastTime').html(`
    				<p class="text-center text-info">
    					Lần điểm danh cuối:
    					<span class="text-danger">
    						<strong>${res.created_at}</strong>
    					</span>
    				</p>`);

    			// so gio da day
				$('#info #timeDone').html(`
				<span>
					Số giờ đã dạy: <strong class="text-danger">${res.time_done}</strong> giờ
				</span> 
				<span>
					Số giờ còn lại: <strong class="text-danger">
					${res.totalTime - res.time_done}</strong> giờ
				</span>`);
    		},
    		error: (res) => {
    			let error = res.responseJSON;
				console.log(error);

				$('#titleInfo').html('');

				$('#attendanceTable').hide();

				// redirect to 404 page if not found data
				if (error.hasOwnProperty('url')) {
					window.location.replace(error.url);
				}

				// show error message
				if (error.hasOwnProperty('message')) {
					render_alert('error', error.message, '#message');

					// hide alert after time
					hide_after('.alert', 5000);
				}

				// show info
				if (error.hasOwnProperty('info') 
					&& error.hasOwnProperty('created_at')) {

					// so gio da day
					$('#info #timeDone').html(`
					<span>
						Số giờ đã dạy: <strong class="text-danger">
						${error.time_done}</strong> giờ
					</span> 
					<span>
						Số giờ còn lại: <strong class="text-danger">
						${error.totalTime - error.time_done}</strong> giờ
					</span>`);

					// lan diem danh cuoi
					$('#info #lastTime').html(`
    				<p class="text-center text-info">
    					Lần điểm danh cuối:
    					<span class="text-danger">
    						<strong>${error.created_at}</strong>
    					</span>
    				</p>`);
				}
    		}
    	});
    }

	function get_data() {
		let data = [];

		$.each($(`#attendanceForm :radio:checked`), function(k, v) {
			let id = $($('.id')[k]).val();
			let status = $(v).val();
			let note = $($('.note')[k]).val();

			let row = {id_student: id, status: status, note: note};
			data.push(row);
			console.log(row);
		});

		data = JSON.stringify(data);
		// console.log(data);
		return data;
	}
</script>
@endpush