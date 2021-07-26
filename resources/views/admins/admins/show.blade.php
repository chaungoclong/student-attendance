@extends('layouts.app')

@section('title', __('admin'))

@section('name_page', 'List admin')

@section('content')
<div>
	{{ Breadcrumbs::render() }}
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<form class="form-horizontal" action="{{ 
				route('admin.admin-manager.update', $admin->id) }}" method="POST">
				@csrf
				@method('put')
				<input type="hidden" name="id" value="{{ $admin->id }}">
				<div class="card-header card-header-text" data-background-color="rose">
					<h4 class="card-title">Profile admin</h4>
				</div>

				<div class="card-content">
					<div class="row">
						<label class="col-sm-2 label-on-right">Fullname</label>
						<div class="col-sm-10">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<input type="text" class="form-control" name="name" value="{{ old('name', $admin->name) }}">
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
								<input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}" >
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
								<input type="number" class="form-control" name="phone" value="{{ old('phone', $admin->phone) }}" >
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
								<input type="text" class="form-control" name="address" value="{{ old('address', $admin->address) }}">
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
								<input type="text" class="form-control datepicker" name="dob" value="{{ old('dob', $admin->dob) }}"/>
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
										{{ $admin->gender == 'Nam' 
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
										{{ $admin->gender == 'Nữ' 
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
						<div class="col-sm-5">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="status" id="" class="selectpicker" data-style="select-with-transition" title="Choose Status">
									<option value="" disabled>Choose Status</option>
									<option value="1"
										@if (old('status') !== null))
											{{ old('status') == '1' 
												? 'selected' : '' }}
										@else
											{{ $admin->status == '1' 
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
											{{ $admin->status == '0' 
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
						<label class="col-sm-2 label-on-right">Role</label>
						<div class="col-sm-5">
							<div class="form-group label-floating is-empty">
								<label class="control-label"></label>
								<select name="is_super" id="" class="selectpicker" data-style="select-with-transition" title="Choose Role">
									<option value="" disabled>Choose Role</option>
									<option value="1"
										@if (old('is_super') !== null))
											{{ old('is_super') == '1' 
												? 'selected' : '' }}
										@else
											{{ $admin->is_super == '1' 
												? 'selected' : '' }}
										@endif
									>
										Super Admin
									</option>
									<option value="0"
										@if (old('is_super') !== null))
											{{ old('is_super') == '0' 
												? 'selected' : '' }}
										@else
											{{ $admin->is_super == '0' 
												? 'selected' : '' }}
										@endif
									>
										Admin
									</option>
								</select>
								@error('is_super')
									<div class="alert alert-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							@if (! $admin->is_super)
								<button class="btn btn-success btn-round">
									save
								</button>
								<button type="reset" class="btn btn-warning btn-round">
									reset
								</button>
							@endif
							<button type="button" class="btn btn-danger btn-round" onclick="window.location.replace('{{ route('admin.admin-manager.index') }}')">back</button>
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