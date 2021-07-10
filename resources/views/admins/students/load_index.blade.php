@foreach ($students as $student)
<tr>
	<td>{{ $student->id }}</td>
	<td>{{ $student->name }}</td>
	<td>{{ $student->code }}</td>
	<td>{{ $student->email }}</td>
	<td>{{ $student->phone }}</td>
	<td>{{ $student->dob }}</td>
	<td>{{ $student->address }}</td>
	<td>{{ $student->gender }}</td>
	<td>{{ $student->grade->name }}</td>
	<td class="td-actions text-right" 
	style="display: flex; justify-content: space-around;">
		<a href="{{ route('admin.student-manager.show', $student->id) }}">
			<button type="button" rel="tooltip" class="btn btn-info">
				<i class="material-icons">person</i>
			</button>
		</a>
		<a href="{{ route('admin.student-manager.show', $student->id) }}">
			<button type="submit" rel="tooltip" class="btn btn-success">
				<i class="material-icons">edit</i>
			</button>
		</a>
	</td>
</tr>
@endforeach
<tr>
	<td colspan="8">
		{{ $students->links() }}
	</td>
</tr>