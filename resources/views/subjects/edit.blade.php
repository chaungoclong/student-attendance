@extends('layouts.app')

@section('content')
<h1>New Subject</h1>
<form action="{{ route('admin.subject.update', $subject->id) }}" method="POST">
	@csrf
	@method('PUT')
	<label>Name: </label>
	<input type="text" name="subject" class="input" value="{{ $subject->name }}">
	<label>Time (h): </label>
	<input type="number" min="0" name="time" class="input" value="{{ $subject->duration }}">
	<input type="submit" value="Submit" class="btn btn-success">
</form>
@stop