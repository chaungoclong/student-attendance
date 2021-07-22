@extends('layouts.app')

@section('title', __('student'))

@section('name_page', 'List student')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-content">
		<div class="card-header" style="display: flex; justify-content: space-between; align-items: center;"> 

			{{-- number of row to show --}}
			<div class="col-lg-1 col-md-1 col-sm-1">
				<select class="selectpicker" data-style="select-with-transition" title="Choose row" id="row">
					<option value disabled>Choose row</option>
					<option value="10" selected>10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>

			{{-- filter grade --}}
			<div class="col-lg-2 col-md-2 col-sm-2">
				<select class="selectpicker" data-style="select-with-transition" title="Choose grade" data-size="7" id="filterGrade">
					<option value disabled> Choose grade</option>
					<option value="">All</option>
					@foreach ($grades as $grade)
					<option value="{{ $grade->id }}">
						{{ $grade->name . $grade->yearSchool->name }}
					</option>
					@endforeach
				</select>
			</div>
			
			{{-- filter gender --}}
			<div class="col-lg-2 col-md-2 col-sm-2">
				<select class="selectpicker" data-style="select-with-transition" title="choose gender" data-size="7" id="filterGender">
					<option value disabled> Choose gender</option>
					<option value="">All</option>
					<option value="1">Male </option>
					<option value="0">Female</option>
				</select>
			</div>

			{{-- search --}}
			<form class="navbar-form navbar-right" id="formSearch">
				<div class="form-group form-search is-empty">
					<input type="text" class="form-control" placeholder=" Search " name="search" value="" id="searchBar">
					<span class="material-input"></span>
				</div>
				<button type="submit" class="btn btn-white btn-round btn-just-icon" id="btnSearch">
					<i class="material-icons">search</i>
					<div class="ripple-container"></div>
				</button>
			</form>

			{{-- add --}}
			<a href="{{ route('admin.student-manager.create') }}">
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
						<th>Code</th>
						<th>Email</th>
						<th>Phone</th>
						<th>DOB</th>
						<th>Address</th>
						<th>Gender</th>
						<th>Class</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@include('admins.students.load_index')
				</tbody>
			</table>

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

		// fetch data when type in search bar
		$(document).on('keyup', '#searchBar', function() {
			let row = $('#row').val();
			let grade = $('#filterGrade').val();
			let gender = $('#filterGender').val();
			let search = $(this).val();

			fetch_page(search, row, gender, grade);
		});

		// fetch data when type in search bar
		$(document).on('change', '#filterGrade', function() {
			let row = $('#row').val();
			let grade = $(this).val();
			let gender = $('#filterGender').val();
			let search = $('#searchBar').val();

			fetch_page(search, row, gender, grade);
		});

		// fetch data when choose row
		$(document).on('change', '#row', function() {
			let row = $(this).val();
			let grade = $('#filterGrade').val();
			let gender = $('#filterGender').val();
			let search = $('#searchBar').val();

			fetch_page(search, row, gender, grade);
		});

		// fetch data when choose gender
		$(document).on('change', '#filterGender', function() {
			let row = $('#row').val();
			let grade = $('#filterGrade').val();
			let gender = $(this).val();
			let search = $('#searchBar').val();

			fetch_page(search, row, gender, grade);
		});

		// fetch data when click search button
		$(document).on('click', '#btnSearch', function(e) {
			e.preventDefault();
		});

		// fetch data when switch page
		$(document).on('click', '.pagination a', function(e) {
			e.preventDefault();
			
			let row = $('#row').val();
			let grade = $('#filterGrade').val();
			let gender = $('#filterGender').val();
			let search = $('#searchBar').val();
			let page = $(this).attr('href').split('page=')[1];

			fetch_page(search, row, gender, grade, page);
		});
	});

	function fetch_page(search, row = 10, gender, grade, page = 1) {
		let url =  `{{ route('admin.student-manager.index') }}?row=${row}&grade=${grade}&gender=${gender}&search=${search}&page=${page}`;

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function(res) {
				$('tbody').html(res.html);
			},
			error: function(res) {
				let error = res.responseJSON;

				// redirect if unauthenticate
				if (error.hasOwnProperty('url')) {
					window.location.replace(error.url);
				}
			}
		});
	}
</script>
@endpush