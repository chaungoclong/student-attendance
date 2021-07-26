@extends('layouts.app')

@section('content')
@if(Session::has('message'))
	@if(Session::get('message')['status'] == true)
		<div class="alert alert-success">{{ Session::get('message')['content'] }}</div>
	@endif
	@if(Session::get('message') == false)
		<div class="alert alert-danger">{{ Session::get('message')['content'] }}</div>
	@endif
@endif
<h1>List All Lesson</h1>
<h3>Add New Lesson</h3>
<form action="{{ route('admin.lesson.store') }}", method="POST">
	@csrf
	<label>Time Start: </label>
	<input type="time" name="start" class="input" value="{{ old('start') }}">
	<label>Time End: </label>
	<input type="time" name="end" class="input" value="{{ old('end') }}">
	<input type="submit" value="Submit" class="btn btn-success">
</form>
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
<table class="table">
	<tr>
		<th>Id</th>
		<th>Time Start</th>
		<th>Time End</th>
		<th>Action</th>
	</tr>
	@foreach($lessons as $lesson)
	<tr>
		<td>{{ $lesson->id }}</td>
		<td>{{ $lesson->start }}</td>
		<td>{{ $lesson->end }}</td>
		<td>
			<a href="{{ route('admin.lesson.edit', $lesson->id) }}" class="btn btn-info">Edit</a>
		</td>
	</tr>
	@endforeach
</table>
<div>{{ $lessons->links() }}</div>
@stop