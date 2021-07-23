@extends('layouts.app')

@section('title', __('student'))

@section('name_page', 'List student')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<form method="post" action="
			{{ route('admin.student-manager.update', $student->id) }}" class="form-horizontal">
				@csrf
				@method('put')
				<input type="hidden" name="id" value="{{ $student->id }}">
				<div class="card-header card-header-text" data-background-color="rose">
					<h4 class="card-title">Profile student</h4>
				</div>

				<div class="card-content">
					<div class="row">
						<label class="col-sm-2 label-on-right">Student Code</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="text" class="form-control" name="code" value="{{ old('code', $student->code) }}">
								@error('code')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
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
												|| $grade->id == $student->grade->id 
												? 'selected' : '' 
											}}
										>
											{{ $grade->name . $grade->yearSchool->name }}
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
						<label class="col-sm-2 label-on-right">Fullname</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="text" class="form-control" name="name" value="{{ old('name', $student->name) }}">
								@error('name')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Email Address</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="email" class="form-control" name="email" value="{{ old('email', $student->email) }}">
								@error('email')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Phone Number</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="number" class="form-control" name="phone" value="{{ old('phone', $student->phone) }}">
								@error('phone')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Address</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="text" class="form-control" name="address" value="{{ old('address', $student->address) }}">
								@error('address')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Date Of Birth</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="text" class="form-control datepicker" name="dob" value="{{ old('dob', $student->dob) }}" />
								@error('dob')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Gender</label>
						<div class="col-sm-10 checkbox-radios">
							<div class="radio">
								<label>
									<input type="radio" name="gender" value="1"
									@if (old('gender') !== null))
										{{ old('gender') == '1' 
											? 'checked' : '' }}
									@else
										{{ $student->gender == 'Nam' 
											? 'checked' : '' }}
									@endif> Male
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="gender" value="0"
									@if (old('gender') !== null))
										{{ old('gender') == '0' 
											? 'checked' : '' }}
									@else
										{{ $student->gender == 'Nữ' 
											? 'checked' : '' }}
									@endif> Female
								</label>
							</div>
							@error('gender')
								<div class="alert alert-danger">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 label-on-right">Status</label>
						<div class="col-sm-2">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="status" id="" class="selectpicker" data-style="select-with-transition" title="Choose Status">
									<option value="" disabled>Choose Status</option>
									<option value="1"
										@if (old('status') !== null))
											{{ old('status') == '1' 
												? 'selected' : '' }}
										@else
											{{ $student->status == '1' 
												? 'selected' : '' }}
										@endif
									>
										Active
									</option>
									<option value="0"
										@if (old('status') !== null))
											{{ old('status') == '0' 
												? 'selected' : '' }}
										@else
											{{ $student->status == '0' 
												? 'selected' : '' }}
										@endif
									>
										Inactive
									</option>
								</select>
								@error('status')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-success btn-round">save</button>
							<button type="reset" class="btn btn-warning btn-round">reset</button>
							<button type="button" class="btn btn-danger btn-round" onclick="window.location.replace('{{ route('admin.student-manager.index') }}')">back</button>
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