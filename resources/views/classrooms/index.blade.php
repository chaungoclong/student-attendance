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
<h1>List Class Rooms</h1>
<form action="{{ route('classroom.store') }}" method="POST">
	@csrf
	<label style="font-size: 20px">Add New Class Room: </label>
	<input type="text" name="classroom" class="input">
	<input type="submit" value="Add New" class="btn btn-success">
</form>
<table class="table">
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th>Create At</th>
		<th>Update At</th>
		<th colspan="2">Action</th>
	</tr>
	@foreach($classrooms as $classroom)
	<tr>
		<td>{{ $classroom->id }}</td>
		<td>{{ $classroom->name }}</td>
		<td>{{ $classroom->created_at }}</td>
		<td>{{ $classroom->updated_at }}</td>
		<td>
			<a href="{{ route('classroom.edit', $classroom->id) }}" class="btn btn-info">Edit</a>
		</td>
		<td>
			<form action="{{ route('classroom.destroy', $classroom->id) }}" method="POST">
				@csrf
				@method('delete')
				<input type="submit" value="Delete" class="btn btn-danger">
			</form>
		</td>
	</tr>
	@endforeach
</table>
<div>{{ $classrooms->links() }}</div>
@stop