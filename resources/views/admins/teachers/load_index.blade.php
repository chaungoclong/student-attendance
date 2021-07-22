@foreach ($teachers as $teacher)
<tr>
	<td>{{ $teacher->id }}</td>
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
	<td class="td-actions text-center">
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
<tr>
	<td colspan="9">
		{{ $teachers->links() }}
	</td>
</tr>