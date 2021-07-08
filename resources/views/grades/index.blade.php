@extends('layouts.app')

@section('content')
@if(Session::has('message'))
	@if(Session::get('message')['status'] == 1)
		<div class="alert alert-success">{{ Session::get('message')['content'] }}</div>
	@endif
	@if(Session::get('message') == 0)
		<div class="alert alert-danger">{{ Session::get('message')['content'] }}</div>
	@endif
@endif
<h1>List All Grades</h1>
<a href="{{ route('admin.grade.create') }}" class="btn">Add New Grade</a>
@foreach ($dataGrades as $dataGrade)
	<h2>{{ $dataGrade['name'] }}</h2>
	@if(isset($dataGrade[$dataGrade['id']]))
		<table class="table">
			<tr>
				<th>Id</th>
				<th>Grade</th>
				<th>Create At</th>
				<th>Update At</th>
				<th colspan="2">Action</th>
			</tr>
			@foreach($dataGrade[$dataGrade['id']] as $grade)
			<tr>
				<td>{{ $grade->id }}</td>
				<td>{{ $grade->name }}</td>
				<td>{{ $grade->created_at }}</td>
				<td>{{ $grade->updated_at }}</td>
				<td>
					<a href="{{ route('admin.grade.edit', $grade->id) }}" class="btn btn-info">Edit</a>
				</td>
				<td>
					<form action="{{ route('admin.grade.destroy', $grade->id) }}" method="POST">
						@csrf
						@method('delete')
						<input type="submit" value="Delete" class="btn btn-danger">
					</form>
				</td>
			</tr>
			@endforeach
		</table>
		@endif
@endforeach
@stop