@foreach ($admins as $admin)
<tr>
	<td>{{ $admin->id }}</td>
	<td>
		{{ $admin->name }}
		@if (Auth::id() == $admin->id)
			<strong class="text-rose badge" 
			style="background: #4df74c;">YOU</strong>
		@endif
	</td>
	<td>{{ $admin->email }}</td>
	<td>{{ $admin->phone }}</td>
	<td>{{ $admin->dob }}</td>
	<td>{{ $admin->address }}</td>
	<td>{{ $admin->gender }}</td>
	<td class="td-actions text-right" 
	style="display: flex; justify-content: space-around;">
		<a href="{{ route('admin.admin-manager.show', $admin->id) }}">
			<button type="button" rel="tooltip" class="btn btn-info">
				<i class="material-icons">person</i>
			</button>
		</a>
	</td>
</tr>
@endforeach
<tr>
	<td colspan="8">
		{{ $admins->links() }}
	</td>
</tr>