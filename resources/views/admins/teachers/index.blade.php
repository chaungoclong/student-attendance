@extends('layouts.app')

@section('title', __('Teacher'))

@section('name_page', 'List Teacher')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-content">
		<div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
			<h4>Teacher table</h4> 

			{{-- filter --}}
			<div class="col-lg-3 col-md-3 col-sm-3">
				<select class="selectpicker" data-style="select-with-transition" title="Choose gender" data-size="7">
					<option value> Choose gender</option>
					<option value="1">Male </option>
					<option value="0">Fenale</option>
				</select>
			</div>

			{{-- search --}}
			<form class="navbar-form navbar-right"
			action="{{ route('admin.teacher-manager.index') }}" 
			method="get" id="formSearch">
			<div class="form-group form-search is-empty">
				<input type="text" class="form-control" placeholder=" Search " name="search" value="{{ $search }}" id="searchBar">
				<span class="material-input"></span>
			</div>
			<button type="submit" class="btn btn-white btn-round btn-just-icon">
				<i class="material-icons">search</i>
				<div class="ripple-container"></div>
			</button>
		</form>

		{{-- add --}}
		<a href="{{ route('admin.teacher-manager.create') }}">
			<button class="btn btn-success">Add new</button>
		</a>
	</div>
	{{-- alert success --}}
	@if (session('success'))
	<div class="alert alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Success!</strong> {{ session('success') }}
	</div>
	@endif

	{{-- alert error --}}
	@if (session('error'))
	<div class="alert alert-dismissable alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Error!</strong> {{ session('error') }}
	</div>
	@endif

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>DOB</th>
					<th>Address</th>
					<th>Gender</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($teachers as $teacher)
				<tr>
					<td>{{ $teacher->id }}</td>
					<td>{{ $teacher->name }}</td>
					<td>{{ $teacher->email }}</td>
					<td>{{ $teacher->phone }}</td>
					<td>{{ $teacher->dob }}</td>
					<td>{{ $teacher->address }}</td>
					<td>{{ $teacher->gender }}</td>
					<td class="td-actions text-right" 
					style="display: flex; justify-content: space-around;">
					<a href="{{ route('admin.teacher-manager.show', $teacher->id) }}">
						<button type="button" rel="tooltip" class="btn btn-info">
							<i class="material-icons">person</i>
						</button>
					</a>
					<a href="{{ route('admin.teacher-manager.show', $teacher->id) }}">
						<button type="submit" rel="tooltip" class="btn btn-success">
							<i class="material-icons">edit</i>
						</button>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $teachers->appends(['search' => $search])->links() }}
</div>
</div>
</div>
@stop
@push('script')
<script type="text/javascript">
	$(function() {
		// hide alert after time
		setTimeout(() => {
			$('.alert').remove();
		}, 5000);
	});
</script>
@endpush