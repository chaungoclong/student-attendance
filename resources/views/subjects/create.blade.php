@extends('layouts.app')

@section('content')
<h1>New Subject</h1>
<form action="{{ route('subject.store') }}" method="POST">
	@csrf
	<label>Name: </label>
	<input type="text" name="subject" class="input">
	<label>Time (h): </label>
	<input type="number" min="0" name="time" class="input">
	<input type="submit" value="Submit" class="btn btn-success">
</form>
@stop