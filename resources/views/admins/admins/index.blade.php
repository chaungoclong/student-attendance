@extends('layouts.app')

@section('title', __('admin'))

@section('name_page', 'List admin')

@section('content')
<div class="card">
	<div class="card-header card-header-icon" data-background-color="rose">
		<i class="material-icons">assignment</i>
	</div>
	<div class="card-content">
		<div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">

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

			{{-- filter --}}
			<div class="col-lg-3 col-md-3 col-sm-3">
				<select class="selectpicker" data-style="select-with-transition" title="Choose gender" data-size="7" id="filterGender">
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
			<a href="{{ route('admin.admin-manager.create') }}">
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
				@include('admins.admins.load_index')
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
			let search = $(this).val();
			let gender = $('#filterGender').val();
			let row = $('#row').val();
			fetch_page(search, row, gender);
		});

		// fetch data when choose row
		$(document).on('change', '#row', function() {
			let search = $('#searchBar').val();
			let gender = $('#filterGender').val();
			let row = $(this).val();
			fetch_page(search, row, gender);
		});

		// fetch data when choose gender
		$(document).on('change', '#filterGender', function() {
			let gender = $(this).val();
			let search = $('#searchBar').val();
			let row = $('#row').val();
			fetch_page(search, row, gender);
		});

		// fetch data when click search button
		$(document).on('click', '#btnSearch', function(e) {
			e.preventDefault();
		});

		// fetch data when switch page
		$(document).on('click', '.pagination a', function(e) {
			e.preventDefault();
			let search = $('#searchBar').val();
			let gender = $('#filterGender').val();
			let page = $(this).attr('href').split('page=')[1];
			let row = $('#row').val();
			fetch_page(search, row, gender, page);
		});
	});

	function fetch_page(search, row = 5, gender = 2, page = 1) {
		let url =  `{{ route('admin.admin-manager.index') }}?search=${search}&page=${page}&gender=${gender}&row=${row}`;

		$.ajax({
			url: url,
			type: 'GET',
			success: function(res) {
				$('tbody').html(res);
			},
			error: function(res) {
				// redirect if unauthenticate
				window.location.replace(res.responseJSON.redirectTo);
			}
		});
	}
</script>
@endpush