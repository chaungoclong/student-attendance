@extends('layouts.app')

@section('title', __('Assign'))

@section('name_page', 'Create Assign')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app/assigns/create.css') }}">
@endpush

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<form class="form-horizontal" id="form">
				@csrf

				{{-- title --}}
				<div class="card-header" data-background-color="blue">
					<h4 class="card-title">ADD ASSIGN</h4>
				</div>

				{{-- alert --}}
				<div class="card-header">
					<div id="message"></div>
				</div>

				<div class="card-content">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th class="text-center" width="30%">GRADE</th>
									<th class="text-center" width="30%">SUBJECT</th>
									<th class="text-center" width="30%">TEACHER</th>
									<th class="text-center" width="10%">REMOVE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="col-input">
										<select name="id_grade[]" title="Grade" class="select-grade select">
											<option disabled selected>
												Choose Grade
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
										<select name="id_subject[]" title="Subject" class="select-subject select">
											<option disabled selected>
												Choose Subject
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
										<select name="id_teacher[]" title="Teacher" class="select-teacher select">
											<option disabled selected>
												Choose Teacher
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
										<i class="fas fa-times fa-2x remove-row" data-toggle="tooltip" title="remove this row"  data-placement="left"></i>
									</td>	
								</tr>
							</tbody>
						</table>
					</div>

					<div class="row text-center">
						<button type="button" class="btn btn-primary btn-round" id="addRow">NEW ASSIGN</button>
						<button class="btn btn-success btn-round" id="btnSubmit">SAVE</button>
						<button type="reset" class="btn btn-warning btn-round">RESET</button>
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
		$('[data-toggle="tooltip"]').tooltip();

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
			trNew.hide().insertAfter(trLast).fadeIn('slow');

			// clear error
			$('.show-error').html('').removeClass('error');
			$('[data-toggle="tooltip"]').tooltip();
		});

		// remove row
		$(document).on('click', '.remove-row', function() {
			let numberOfRow = $('tbody tr').length;

			if (numberOfRow > 1) {
				$(this).closest('tr').fadeOut('slow', function() {
					$(this).remove();
				});
			} else {
				$('#message').html('cannot remove this row').addClass('alert alert-danger');

				setTimeout(() => {
					$('#message').html('').removeClass('alert alert-danger');
				}, 5000);
			}
		});

		// clear error when select
		$(document).on('change', '.select', function() {
			$('.show-error').html('').removeClass('error');
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
				window.location.replace(res.url);
			},
			error: (res) => {
				let errorRes = res.responseJSON;

				let allErrors = $('.show-error');
				let errorGrades = $('.error-grade');
				let errorSubjects = $('.error-subject');
				let errorTeachers = $('.error-teacher');

				$(allErrors).html('').removeClass('error');

				if (errorRes.code == 1) {
					let errorRows = errorRes.errorRows;
					let message = errorRes.message;

					for (let i of errorRows) {
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