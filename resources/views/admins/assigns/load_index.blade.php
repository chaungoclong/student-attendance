@foreach ($assigns as $assign)
<tr>
	<td>{{ $assign->grade->name }}</td>
	<td>{{ $assign->subject->name }}</td>
	<td>{{ $assign->teacher->name }}</td>
	<td>{{ $assign->time_done }}</td>
	<td>{{ $assign->start_at }}</td>
	<td class="text-center">
		@switch($assign->status)
		    @case('1')
		        <span class="badge" style="background: green;">Teaching</span>
		        @break;

		    @case('2')
		        <span class="badge" style="background: red;">Completed</span>
		        @break;
		    @default
		        <span class="badge" style="background: red;">Inactive</span>
		@endswitch
	</td>
	<td class="td-actions text-right">
		@if (count($assign->attendances) == 0 
			&& count($assign->schedules) == 0)
			<form action="{{ route('admin.assign.destroy', $assign) }}" method="POST" style="display: inline-block;">
					@csrf
					@method('delete')
					<button type="submit" rel="tooltip" class="btn btn-danger btn-round" data-toggle="tooltip" title="Delete" data-placement="left" onclick="return confirm('are you sure?')">
						<i class="material-icons">close</i>
					</button>
		    </form>
		@endif
	</td>
</tr>
@endforeach
<tr>
	<td colspan="7">
		{{ $assigns->links() }}
	</td>
</tr>