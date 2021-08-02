@foreach ($students as $student)
	<tr>
		<td>
			{{ $student->code }}
			<input type="hidden" value="{{ $student->id }}" class="id" 
			id="id_{{ $student->id }}">
		</td>
		<td>{{ $student->name }}</td>
		<td width="26%" style="">
			<div style="display: flex;">
				<div class="radio" style="margin-right: 70px;">
					<label style="color: green;">
						<input class="status" type="radio" name="status_{{ $student->id }}" value="1" checked>Present
					</label>
				</div>

				<div class="radio" style="margin-right: 70px;">
					<label style="color: red;">
						<input class="status" type="radio" name="status_{{ $student->id }}" value="0">Absent
					</label>
				</div>

				<div class="radio">
					<label style="color: orange;">
						<input class="status" type="radio" name="status_{{ $student->id }}" value="2">Late
					</label>
				</div>
			</div>
		</td>
		<td>
			<div class="form-group">
				<input class="note form-control" type="text"
				id="note_{{ $student->id }}">
			</div>
		</td>
	</tr>
@endforeach
<tr>
	<td colspan="4">
		<textarea name="" id="notePrimary" rows="6" style="width: 100%; border-radius: 10px; border-color: blue; padding: 5px;;" placeholder="note"></textarea>
	</td>
</tr>
<tr>
	<td colspan="4">
		<div class="text-center">
			<button class="btn btn-success" type="button" id="saveBtn">SAVE</button>
		</div>
	</td>
</tr>