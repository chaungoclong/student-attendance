@extends('layouts.app')

@section('title', __('Assign'))

@section('name_page', 'Create Assign')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<form method="post" action="
			{{ route('admin.assign.store') }}" class="form-horizontal">
				@csrf
				<div class="card-header card-header-text" data-background-color="rose">
					<h4 class="card-title">Add Assign</h4>
				</div>

				<div class="card-content">
					<div class="row">
						<label class="col-sm-2 label-on-right">Grade</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="id_grade" id="" class="selectpicker" data-style="select-with-transition" title="Choose Grade">
									<option value="" disabled>Choose Grade</option>
									@foreach ($grades as $grade)
										<option value="{{ $grade->id }}" 
											{{ 
												$grade->id == old('id_grade') 
												? 'selected' : '' 
											}}
										>
											{{ $grade->name }}
										</option>
									@endforeach
								</select>
								@error('id_grade')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Subject</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="id_subject" id="" class="selectpicker" data-style="select-with-transition" title="Choose Subject">
									<option value="" disabled>Choose Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}" 
											{{ 
												$subject->id == old('id_subject') 
												? 'selected' : '' 
											}}
										>
											{{ $subject->name }}
										</option>
									@endforeach
								</select>
								@error('id_grade')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Teacher</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="id_teacher" id="" class="selectpicker" data-style="select-with-transition" title="Choose Teacher">
									<option value="" disabled>Choose Teacher</option>
									@foreach ($teachers as $teacher)
										<option value="{{ $teacher->id }}" 
											{{ 
												$teacher->id == old('id_teacher') 
												? 'selected' : '' 
											}}
										>
											{{ $teacher->name }}
										</option>
									@endforeach
								</select>
								@error('id_grade')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-success">save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop
@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        demo.initFormExtendedDatetimepickers();
    });
</script>
@endpush