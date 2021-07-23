@foreach ($teachers as $teacher)
<tr>
	<td>{{ str_pad($teacher->id, 2, "0", STR_PAD_LEFT) }}</td>
	<td>{{ $teacher->name }}</td>
	<td>{{ $teacher->email }}</td>
	<td>{{ $teacher->phone }}</td>
	<td>{{ $teacher->dob }}</td>
	<td>{{ $teacher->address }}</td>
	<td>{{ $teacher->gender }}</td>
	<td class="text-center">
		@if ($teacher->status)
			<span class="badge" style="background: green;">Active</span>
		@else
			<span class="badge" style="background: red;">Inactive</span>
		@endif
	</td>
	<td class="td-actions text-right">
		<a href="{{ route('admin.teacher-manager.show', $teacher->id) }}">
			<button type="button" rel="tooltip" class="btn btn-info btn-info btn-round" data-toggle="tooltip" title="View and Edit" data-placement="left">
				<i class="material-icons">edit</i>
			</button>
		</a>
		<a href="{{ route('admin.teacher-manager.show', $teacher->id) }}">
			<button type="button" rel="tooltip" class="btn btn-info btn-danger btn-round" data-toggle="tooltip" title="Delete" data-placement="left">
				<i class="material-icons">close</i>
			</button>
		</a>
	</td>
</tr>
@endforeach
<tr>
	<td colspan="9">
		{{ $teachers->links() }}
	</td>
</tr>