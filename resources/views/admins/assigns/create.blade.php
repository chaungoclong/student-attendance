@extends('layouts.app')

@section('title', __('Assign'))

@section('name_page', 'Create Assign')

<style>
table {
	table-layout: fixed;
	width: 100%;
}

.col-input {
	vertical-align: top !important;
	padding: 8px !important;
}

.col-input select {
	width: 100%;
	height: 30px;
	border-radius: 10px;
	background: #ffffff;
}

.is-error {
	border-color: red;
}

.show-error {
	overflow-wrap: break-word;
	word-wrap: break-word;
	hyphens: auto;
	display: block;
	padding: 3px;
	margin-top: 5px;
}

.error {
	border: 1px solid red;
	border-radius: 5px;
	color: red;
}

.remove-row {
	color: red;
	margin-top: -10px;
}

.remove-row:hover {
	cursor: pointer;
}
</style>

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<form class="form-horizontal" id="form">
				@csrf
				<div class="card-header card-header-text" data-background-color="rose">
					<h4 class="card-title">Add Assign</h4>
				</div>
				<div class="card-header">
					<div id="message"></div>
				</div>
				<div class="card-header">
					<button type="button" class="btn btn-info" id="addRow">
						MORE
					</button>
				</div>

				<div class="card-content">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="30%">GRADE</th>
									<th width="30%">SUBJECT</th>
									<th width="30%">TEACHER</th>
									<th width="10%">REMOVE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="col-input">
										<select name="id_grade[]" title="grade" class="select-grade">
											<option disabled selected>
												choose grade
											</option>
											@foreach ($grades as $grade)
											<option value="{{ $grade->id }}">
												{{ $grade->name }}
											</option>
											@endforeach
										</select>
										<small class="show-error error-grade">
										</small>
									</td>
									<td class="col-input">
										<select name="id_subject[]" title="grade" class="select-subject">
											<option disabled selected>
												choose subject
											</option>
											@foreach ($subjects as $subject)
											<option value="{{ $subject->id }}">
												{{ $subject->name }}
											</option>
											@endforeach
										</select>
										<small class="show-error error-subject">
										</small>
									</td>
									<td class="col-input">
										<select name="id_teacher[]" title="grade" class="select-teacher">
											<option disabled selected>
												choose teacher
											</option>
											@foreach ($teachers as $teacher)
											<option value="{{ $teacher->id }}">
												{{ $teacher->name }}
											</option>
											@endforeach
										</select>
										<small class="show-error error-teacher">

										</small>
									</td>
									<td class="text-center">
										<i class="fas fa-trash-alt fa-lg remove-row"></i>
									</td>	
								</tr>
							</tbody>
						</table>
					</div>

					<div class="row text-center">
						<button class="btn btn-success" id="btnSubmit">SAVE</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop

@push('script')
<script src="{{ asset('assets/js/helpers/array.js') }}"></script>
<script src="{{ asset('assets/js/helpers/selector.js') }}"></script>
<script src="{{ asset('assets/js/app/assigns/validation.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {

		demo.initFormExtendedDatetimepickers();

		// submit form
		$(document).on('click', '#btnSubmit', function(e) {
			e.preventDefault();

			if (validation()) {
				submit();
			}
		});

		// add new row
		$(document).on('click', '#addRow', function() {
			let trLast = $('#form .table tbody tr:last');
			let trNew = trLast.clone();
			trLast.after(trNew);
		});

		// remove row
		$(document).on('click', '.remove-row', function() {
			let numberOfRow = $('tbody tr').length;
			if (numberOfRow > 1) {
				$(this).closest('tr').remove();
			} else {
				$('#message').html('cannot remove this row').addClass('alert alert-danger');

				setTimeout(() => {
					$('#message').html('').removeClass('alert alert-danger');
				}, 5000);
			}
			
		});
	});

	// submit function
	function submit() {
		$.ajax({
			url: '{{ route('admin.assign.store') }}',
			type: 'POST',
			dataType: 'JSON',
			data: $('#form').serialize(),
			success: (res) => {
				localStorage.setItem('assign_success', 'add assign success' );
				window.location.replace(res.redirect);
			},
			error: (res) => {
				console.log(res);
				let errorRes = res.responseJSON;
				console.log(errorRes);

				let allErrors = $('.show-error');
				let errorGrades = $('.error-grade');
				let errorSubjects = $('.error-subject');
				let errorTeachers = $('.error-teacher');

				$(allErrors).html('').removeClass('error');

				if (errorRes.code == 1) {
					let errorRows = errorRes.errorRows;

					for (let i of errorRows) {
						let message = errorRes.message;

						$(errorGrades[i]).html(message).addClass('error');
						$(errorSubjects[i]).html(message).addClass('error');
						$(errorTeachers[i]).html(message).addClass('error');
					} 
				}

				if (errorRes.code == 2) {
					$('#message').html('').removeClass('alert alert-danger');

					let message = errorRes.message;

					$('#message').html(message).addClass('alert alert-danger');
				}
			}
		});
	}
</script>
@endpush