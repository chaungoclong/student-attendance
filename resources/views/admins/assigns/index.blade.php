@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-header">
		{{-- add --}}
		<a href="{{ route('admin.assign.create') }}">
			<button class="btn btn-success">Add new</button>
		</a>
	</div>
	<div class="card-content">

		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Grade</th>
						<th>Subject</th>
						<th>Teacher</th>
						<th>Duration</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($assigns as $assign)
					<tr>
						<td>{{ $assign->grade->name }}</td>
						<td>{{ $assign->subject->name }}</td>
						<td>{{ $assign->teacher->name }}</td>
						<td>{{ $assign->time_done }}</td>
						<td>
							<a href="">
								<button type="submit" rel="tooltip" class="btn btn-success">
									<i class="material-icons">edit</i>
								</button>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop