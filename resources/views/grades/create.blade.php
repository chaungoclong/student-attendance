@extends('layouts.app')

@section('content')
<h1>New Grade</h1>
<form action="{{ route('grade.store') }}" method="POST">
	@csrf
	<label>Year School: </label>
	<select name="idyearschool" style="height: 40px;">
		<option value="0">--Select Year School--</option>
		@foreach($yearschools as $yearschool)
		<option value="{{ $yearschool->id }}">{{ $yearschool->name }}</option>
		@endforeach
	</select>
	<label>Name: </label>
	<input type="text" name="grade" style="height: 40px;">
	<input type="submit" value="Submit" class="btn">
</form>
@error('idyearschool')
	<span class="invalid-feedback" role="alert">
        <p>{{ $message }}</p>
    </span>
@enderror
@error('grade')
	<span class="invalid-feedback" role="alert">
        <p>{{ $message }}</p>
    </span>
@enderror
@stop