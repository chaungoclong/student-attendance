@extends('layouts.app')

@section('title', __('Admin'))

@section('name_page', 'My profile')

@section('content')
<div>
	{{ Breadcrumbs::render() }}
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">

		<form method="post" action="{{ route('profile.update') }}" 
		class="form-horizontal">
			@csrf
			@method('put')
			<input type="hidden" name="id" value="{{ $user->id }}">
			<div class="card-header card-header-text" data-background-color="rose">
				<h4 class="card-title">My Profile</h4>
			</div>

			<div class="card-header">
				{{-- alert success --}}
				@if (session('success'))
				<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Success!</strong> {{ session('success') }}
				</div>
				@endif

				{{-- alert error --}}
				@if (session('error'))
				<div class="alert alert-dismissable alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Error!</strong> {{ session('error') }}
				</div>
				@endif
			</div>

			<div class="card-content">
				<div class="row">
					<label class="col-sm-2 label-on-right">Fullname</label>
					<div class="col-sm-10">
						<div class="form-group label-floating is-empty">
							<label class="control-label"></label>
							<input type="text" class="form-control" name="name" value="{{ old('name') ?? $user->name }}">
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
							<input type="email" class="form-control" name="email" value="{{ old('email') ?? $user->email }}">
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
							<input type="number" class="form-control" name="phone" value="{{ old('phone') ?? $user->phone }}">
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
							<input type="text" class="form-control" name="address" value="{{ old('address') ?? $user->address }}">
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
							<input type="text" class="form-control datepicker" name="dob" value="{{ old('dob') ?? $user->dob }}" />
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
								{{ $user->gender == 'Nam' 
								? 'checked' : ''}}> Male
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="gender" value="0"
								{{ $user->gender == 'Nữ' 
								? 'checked' : ''}}> Female
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
					<div class="col-md-12 text-center">
						<button class="btn btn-success">save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>

{{-- change password --}}
<div class="row" id="">
	<div class="col-md-12">
		<div class="card">
			<form method="post" action="
			{{ route('password') }}" class="form-horizontal">
			@csrf
			@method('put')
			<div class="card-header card-header-text" data-background-color="rose">
				<h4 class="card-title">Change Password</h4>
			</div>

			<div class="card-header">
				{{-- alert success --}}
				@if (session('change_success'))
				<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Success!</strong> {{ session('change_success') }}
				</div>
				@endif

				{{-- alert error --}}
				@if (session('change_error'))
				<div class="alert alert-dismissable alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Error!</strong> {{ session('change_error') }}
				</div>
				@endif
			</div>

			<div class="card-content">
				<div class="row">
					<label class="col-sm-2 label-on-right">Current password</label>
					<div class="col-sm-10">
						<div class="form-group label-floating is-empty">
							<label class="control-label"></label>
							<input type="password" class="form-control" name="current_password">
							@error('current_password')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-2 label-on-right">New Password</label>
					<div class="col-sm-10">
						<div class="form-group label-floating is-empty">
							<label class="control-label"></label>
							<input type="password" class="form-control" name="password">
							@error('password')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-2 label-on-right">Confirm Password</label>
					<div class="col-sm-10">
						<div class="form-group label-floating is-empty">
							<label class="control-label"></label>
							<input type="password" class="form-control" name="password_confirmation">
							@error('password_confirmation')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center">
						<button class="btn btn-success">Change</button>
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
		setTimeout(() => {
			$('.alert').remove();
		}, 5000);
		
		demo.initFormExtendedDatetimepickers();
	});
</script>
@endpush