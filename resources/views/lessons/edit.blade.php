@extends('layouts.app')

@section('title', 'Lesson Edit')
@section('name_page', 'Lesson Edit')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-content">
		<form action="{{ route('admin.lesson.update', $lesson->id) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="row text-center" style="text-align: center; display:flex; justify-content:center;">
				<div class="col-md-2 form-group">
					<label>Time Start</label>
					<input type="time" name="start" class="input form-control" value="{{ $lesson->start }}">
					@error('start')
						<span class="invalid-feedback text-danger" role="alert">
					        {{ $message }}
					    </span>
					@enderror
				</div>
				<div class="col-md-2 form-group">
					<label>Time End</label>
					<input type="time" name="end" class="input form-control" value="{{ $lesson->end }}">
					@error('end')
						<span class="invalid-feedback text-danger" role="alert">
					        {{ $message }}
					    </span>
					@enderror
				</div>
				<div class="col-md-2 form-group" style="display:flex; align-items:center;">
					<input type="submit" value="Submit" class="btn btn-success btn-round">
				</div>
			</div>
	</form>
	</div>
</div>
<table width="410px">
	<tr align="center">
		<td width="210px">
			@error('start')
				<span class="invalid-feedback" role="alert">
			        {{ $message }}
			    </span>
			@enderror
		</td>
		<td width="200px">
			@error('end')
				<span class="invalid-feedback" role="alert">
			        {{ $message }}
			    </span>
			@enderror
		</td>
	</tr>
</table>
@stop