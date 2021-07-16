@foreach ($assigns as $assign)
<tr>
	<td>{{ $assign->grade->name }}</td>
	<td>{{ $assign->subject->name }}</td>
	<td>{{ $assign->teacher->name }}</td>
	<td>{{ $assign->time_done }}</td>
	<td>
		<a href="">
			<button type="submit" rel="tooltip" class="btn btn-success">
				<i class="material-icons">edit</i>
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