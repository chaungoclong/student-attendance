@extends('layouts.app')

@section('content')
<h1>Edit Year School</h1>
<form action="{{ route('yearschool.update', $yearschool->id) }}" method="POST">
	@csrf
	@method('PUT')
	<span style="font-size: 20px;">Name: </span>
	<input style="height: 40px;" type="text" name="yearschool" value="{{ $yearschool->name }}">
	<input type="submit" value="Update" class="btn btn-success">
</form>
@stop