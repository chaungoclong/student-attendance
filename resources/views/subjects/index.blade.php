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
<h1>List All Subjects</h1>
<a href="{{ route('subject.create') }}" class="btn btn-default">Add New Subject</a>
<table class="table">
	<tr>
		<th>Id</th>
		<th>Subject</th>
		<th>Time (h)</th>
		<th>Create At</th>
		<th>Update At</th>
		<th colspan="2">Action</th>
	</tr>
	@foreach($subjects as $subject)
	<tr>
		<td>{{ $subject->id }}</td>
		<td>{{ $subject->name }}</td>
		<td>{{ $subject->duration }}</td>
		<td>{{ $subject->created_at }}</td>
		<td>{{ $subject->updated_at }}</td>
		<td>
			<a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-info">Edit</a>
		</td>
		<td>
			<form action="{{ route('subject.destroy', $subject->id) }}" method="POST">
				@csrf
				@method('delete')
				<input type="submit" value="Delete" class="btn btn-danger">
			</form>
		</td>
	</tr>
	@endforeach
</table>
<div>{{ $subjects->links() }}</div>
@stop