@extends('layouts.app')

@section('title', __('statistic attendance'))

@section('name_page', 'statistic attendance')

@section('content')

<div class="card">
	<div class="card-content">
		<div class="container-fluid">
			<form action="{{ route('admin.statistic.export') }}" method="POST">
				@csrf
				<div class="row" style="display: flex; justify-content: center; padding: 10px; align-items: center;">
					<div class="form-group col-md-4">
						<select name="id_grade" id="grade" style="width: 100%; padding: 5px;" class="selectpicker">
							<option selected disabled>Choose Grade</option>
							@foreach ($grades as $grade)
							<option value="{{ $grade->id }}">
								{{ $grade->name . $grade->yearSchool->name }}
							</option>
							@endforeach
						</select>

						@error('id_grade')
							<span>{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-4">
						<select name="id_subject[]" id="subject" style="width: 100%; padding: 5px;" class="selectpicker" disabled multiple>
							<option selected disabled>Choose Subject</option>
						</select>

						@error('id_subject')
							<span>{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-2">
						<button class="btn btn-success btn-round" style="margin-top: 20px !important;" id="btnExportExcel">Export</button>
					</div>
				</div>
			</form>
		</div>
		<div class="table-responsive" id="statisticContent">
			
		</div>
	</div>
</div>
@stop
@push('script')
<script type="text/javascript">
	$(function() {
		let app = (function() {
			let grade = $('#grade');
			let subject = $('#subject');
			let btnExportExcel = $('#btnExportExcel');

			return {
				getSubject(idGrade) {
					let data = {id_grade: idGrade, action: "get_subject"};

					$.ajax({
						url: `{{ route('admin.statistic.attendance') }}`,
						type: 'GET',
						dataType: 'json',
						data: data,
						success: (res) => {
							console.log(res);
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
							console.log(res);
						}
					});
				},

				getStatistic(idGrade, idSubject) {
					let data = {
						id_grade: idGrade,
						id_subject: idSubject,
						action: 'get_statistic_attendance'
					};

					$.ajax({
						url: `{{ route('admin.statistic.attendance') }}`,
						type: 'GET',
						dataType: 'json',
						data: data,
						success: (res) => {
							$('#statisticContent').html(res.html);
						},
						error: (res) => {
							console.log(res);
						}
					});
				},

				run() {
					grade.find('option:disabled').prop('selected', true);
					
					$(document).on('change', '#grade', (e) => {
						e.preventDefault();
						this.getSubject(grade.val());
						subject.prop('disabled', false);
					});

					$(document).on('change', '#subject', (e) => {
						e.preventDefault();
						$('#statisticContent').html('');
						this.getStatistic(grade.val(), subject.val());
					});
				}
			}
		})();

		app.run();
	});
</script>
@endpush