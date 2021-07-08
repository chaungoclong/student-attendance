@extends('layouts.app')

@section('content')
<h1>Edit Class Room</h1>
<form action="{{ route('admin.classroom.update', $classroom->id) }}" method="POST">
	@csrf
	@method('PUT')
	<label style="font-size: 20px">Add New Class Room: </label>
	<input type="text" name="classroom" class="input" value="{{ $classroom->name }}">
	<input type="submit" value="Update" class="btn btn-success">
</form>
@stop