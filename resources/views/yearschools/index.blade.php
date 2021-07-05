@extends('layouts.app')

@section('content')
@if(Session::has('message'))
	@if(Session::get('message')['status'] == 1)
		<div class="alert alert-success">{{ Session::get('message')['content'] }}</div>
	@endif
	@if(Session::get('message')['status'] == 0)
		<div class="alert alert-danger">{{ Session::get('message')['content'] }}</div>
	@endif
@endif
<h1>List All Year Schools</h1>
<form action="{{ route('yearschool.store') }}" method="POST">
	@csrf
	<span style="font-weight: bold; font-size: 20px;">Add New: </span>
	<input type="text" name="yearschool" style="height: 40px;">
	<input type="submit" value="Submit" class="btn">
</form>
@error('yearschool')
	<span class="invalid-feedback" role="alert">
        <p>{{ $message }}</p>
    </span>
@enderror
<table class="table">
	<tr>
		<th>Id</th>
		<th>Year School</th>
		<th>Create At</th>
		<th>Update At</th>
		<th colspan="2">Action</th>
	</tr>
	@foreach($yearSchools as $yearSchool)
	<tr>
		<td>{{ $yearSchool->id }}</td>
		<td>{{ $yearSchool->name }}</td>
		<td>{{ $yearSchool->created_at }}</td>
		<td>{{ $yearSchool->updated_at }}</td>
		<td>
			<a href="{{ route('yearschool.edit', $yearSchool->id) }}" class="btn btn-info">Edit</a>
		</td>
		<td>
			<form action="{{ route('yearschool.destroy', $yearSchool->id) }}" method="POST">
				@csrf
				@method('delete')
				<input type="submit" value="Detele" class="btn btn-danger">
			</form>
		</td>
	</tr>
	@endforeach
</table>
<div>{{ $yearSchools->links() }}</div>
@stop