@extends('layouts.auth')

@section('form')
@if (Session::has('msg'))
	<h5 class="alert alert-danger">{{ Session::get('msg') }}</h5>
@endif

<form method="post" action="{{ route('login.teacher') }}">
	@csrf

	<div class="card card-login card-hidden">
		<div class="card-header text-center" data-background-color="green">
			<h4 class="card-title">Teacher Login</h4>
		</div>
		<p class="category text-center">
			Welcome to Teacher Page
		</p>
		<div class="card-content">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="material-icons">email</i>
				</span>
				<div class="form-group label-floating">
					<label class="control-label">Email address</label>
					<input type="email" class="form-control" name="email">
					@error('email')
						 <div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>

			</div>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="material-icons">lock_outline</i>
				</span>
				<div class="form-group label-floating">
					<label class="control-label">Password</label>
					<input type="password" class="form-control" name="password">
					@error('password')
						 <div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
			</div>
		</div>

		<div class="footer text-center">
			<button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Sign in</button>
		</div>
	</div>
</form>
@stop