@extends('layouts.app')

@section('title', 'lessons')
@section('name_page', 'lessons')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-content">
		@if(Session::has('message'))
			@if(Session::get('message')['status'] == true)
				<div class="alert alert-success">{{ Session::get('message')['content'] }}</div>
			@endif
			@if(Session::get('message') == false)
				<div class="alert alert-danger">{{ Session::get('message')['content'] }}</div>
			@endif
		@endif
		<form action="{{ route('admin.lesson.store') }}" method="POST">
			@csrf
			<div class="row text-center" style="text-align: center; display:flex; justify-content:center;">
				<div class="col-md-2 form-group">
					<label>Time Start</label>
					<input type="time" name="start" class="input form-control" value="{{ old('start') }}">
					@error('start')
						<span class="invalid-feedback text-danger" role="alert">
					        {{ $message }}
					    </span>
					@enderror
				</div>
				<div class="col-md-2 form-group">
					<label>Time End</label>
					<input type="time" name="end" class="input form-control" value="{{ old('end') }}">
					@error('end')
						<span class="invalid-feedback text-danger" role="alert">
					        {{ $message }}
					    </span>
					@enderror
				</div>
				<div class="col-md-2 form-group" style="display:flex; align-items:center;">
					<input type="submit" value="Submit" class="btn btn-success">
				</div>
			</div>
		</form>
		<div class="table-responsive" style="margin-top:25px;">
			<table class="table">
				<thead>
					<tr>
					<th>Id</th>
					<th>Time Start</th>
					<th>Time End</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					@foreach($lessons as $lesson)
					<tr>
						<td>{{ $lesson->id }}</td>
						<td>{{ $lesson->start }}</td>
						<td>{{ $lesson->end }}</td>
						<td>
							<a data-toggle="tooltip" title="Edit" href="{{ route('admin.lesson.edit', $lesson->id) }}" class="btn btn-info btn-round" data-placement="right">
								<i class="material-icons">edit</i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div>{{ $lessons->links() }}</div>
	</div>
</div>
@push('script')
<script type="text/javascript">
	$('[data-toggle="tooltip"]').tooltip();
</script>
@endpush
@stop