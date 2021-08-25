@foreach ($assigns as $assign)
<tr>
	<td>{{ $assign->grade->name . $assign->grade->yearSchool->name }}</td>
	<td>{{ $assign->subject->name }}</td>
	<td>{{ $assign->teacher->name }}</td>
	<td>{{ $assign->time_done }}</td>
	<td>{{ $assign->start_at }}</td>
	<td class="text-center">
		@switch($assign->status)
			@case('0')
		        <span class="badge" style="background: red;">Moved</span>
		        @break;

		    @case('1')
		        <span class="badge" style="background: green;">Teaching</span>
		        @break;

		    @case('2')
		        <span class="badge" style="background: orange;">Completed</span>
		        @break;
		    @default
		        <span class="badge" style="background: red;">Inactive</span>
		@endswitch
	</td>
	<td class="td-actions text-right">
		<a href="{{ route('admin.assign.show', $assign->id) }}">
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
	<td colspan="6">
		{{ $assigns->links() }}
	</td>
</tr>