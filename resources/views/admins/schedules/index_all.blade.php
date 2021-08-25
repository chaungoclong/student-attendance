@extends('admins.schedules.layout.index')

@section('title', __('schedules'))

@section('name_page', 'Schedule All')

@section('content.schedules')
<div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">

{{-- number of row to show --}}
<div class="col-lg-1 col-md-1 col-sm-1">
	<select class="selectpicker" data-style="select-with-transition" title="Choose gender" id="row">
		<option value disabled>Choose row</option>
		<option value="10" selected>10</option>
		<option value="25">25</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select>
</div>

{{-- filter grade --}}
<div class="col-lg-3 col-md-3 col-sm-3">
	<select class="selectpicker" data-style="select-with-transition" title="Choose Grade" data-size="7" id="filterGrade">
		<option value disabled> Choose Grade</option>
		<option value="">All</option>
		@foreach ($grades as $grade)
		<option value="{{ $grade->id }}">
			{{ $grade->name . $grade->yearSchool->name }}
		</option>
		@endforeach
	</select>
</div>

{{-- filter subject --}}
<div class="col-lg-3 col-md-3 col-sm-3">
	<select class="selectpicker" data-style="select-with-transition" title="Choose Subject" data-size="7" id="filterSubject">
		<option value disabled> Choose Subject</option>
		<option value="">All</option>
		@foreach ($subjects as $subject)
		<option value="{{ $subject->id }}">
			{{ $subject->name }}
		</option>
		@endforeach
	</select>
</div>

{{-- filter teacher--}}
<div class="col-lg-3 col-md-3 col-sm-3">
	<select class="selectpicker" data-style="select-with-transition" title="Choose Teacher" data-size="7" id="filterTeacher">
		<option value disabled> Choose Teacher</option>
		<option value="">All</option>
		@foreach ($teachers as $teacher)
		<option value="{{ $teacher->id }}">
			{{ $teacher->name }}
		</option>
		@endforeach
	</select>
</div>

{{-- add --}}
<a href="{{ route('admin.schedule.create') }}">
	<button class="btn btn-success btn-round"
	data-toggle="tooltip" title="Add New Assign" data-placement="left" style="padding-left: 14px; padding-right: 14px;">
		<i class="fas fa-plus fa-lg"></i>
	</button>
</a>
</div>

<div class="card-header">
{{-- alert success --}}
@if (session('success'))
<div class="alert alert-dismissable alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
		<span aria-hidden="true">&times;</span>
	</button>
	<strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-dismissable alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
		<span aria-hidden="true">&times;</span>
	</button>
	<strong>Failed!</strong> {{ session('error') }}
</div>
@endif
</div>

<div class="table-responsive">
<table class="table">
	<thead>
		<tr>
			<th>Grade</th>
			<th>Subject</th>
			<th>Teacher</th>
			<th>Class Room</th>
			<th>Day</th>
			<th>Lesson</th>
			<th>Status</th>
			<th class="text-right">Action</th>
		</tr>
	</thead>
	<tbody>
		@include('admins.schedules.load_index_all')
	</tbody>
</table>
</div>
@stop
