@extends('layouts.app')

@section('content')
<h1>Edit Lesson</h1>
<form action="{{ route('admin.lesson.update', $lesson->id) }}" method="POST">
	@csrf
	@method('PUT')
	<label>Time Start: </label>
	<input type="time" name="start" class="input" value="{{ $lesson->start }}">
	<label>Time End: </label>
	<input type="time" name="end" class="input" value="{{ $lesson->end }}">
	<input type="submit" value="Submit" class="btn">
</form>
@error('start')
	<span class="invalid-feedback" role="alert">
        <p>{{ $message }}</p>
    </span>
@enderror
@error('end')
	<span class="invalid-feedback" role="alert">
        <p>{{ $message }}</p>
    </span>
@enderror
@stop