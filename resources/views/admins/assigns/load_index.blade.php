@foreach ($assigns as $assign)
<tr>
	<td>{{ $assign->grade->name . $assign->grade->yearSchool->name }}</td>
	<td>{{ $assign->subject->name }}</td>
	<td>{{ $assign->teacher->name }}</td>
	<td>{{ $assign->time_done }}</td>
	<td class="text-center">
		@if ($assign->status)
			<span class="badge" style="background: green;">Active</span>
		@else
			<span class="badge" style="background: red;">Inactive</span>
		@endif
	</td>
	<td class="td-actions text-right">
		<a href="">
			<button type="button" rel="tooltip" class="btn btn-info btn-info btn-round" data-toggle="tooltip" title="View and Edit" data-placement="left">
				<i class="material-icons">edit</i>
			</button>
		</a>
		<a href="">
			<button type="button" rel="tooltip" class="btn btn-info btn-danger btn-round" data-toggle="tooltip" title="Delete" data-placement="left">
				<i class="material-icons">close</i>
			</button>
		</a>
	</td>
</tr>
@endforeach
<tr>
	<td colspan="5">
		{{ $assigns->links() }}
	</td>
</tr>