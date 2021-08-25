<div style="display: flex;">
    <div class="col-md-4 form-group">
        <select multiple class="input form-control">
            @foreach ($assigns as $assign)
                @if(count($assign->schedules))
                    <option value="{{ $assign->id }}">
                        {{ $assign->subject->name . " - " . $assign->teacher->name }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-1 form-group">
        <a href="#" class="btn btn-round btn-success">Export Custom</a>
    </div>
</div>
<div>
    @foreach ($assigns as $assign)
        <div class="info">
            @if(count($assign->schedules))
                <a data-toggle="collapse" href="#assign{{ $assign->id }}" class="collapsed" style="width: 100%;">
                    <div style="display: flex; justify-content: space-between; align-items:center;" class="alert">
                            <span style="font-size: 20px; font-weight: bold;">{{ $assign->subject->name . " - " . $assign->teacher->name}}
                                <b class="caret"></b>
                            </span>
                        <a href="#" class="btn btn-round btn-success">export</a>
                    </div>
                </a>
            @endif

            <div class="clearfix"></div>
            <div class="collapse" id="assign{{ $assign->id }}">
                @if(count($assign->schedules))
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Class Room</th>
                            <th>Day</th>
                            <th>Lesson</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assign->schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->classRoom->name }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ $schedule->lesson->start." - ".$schedule->lesson->end }}</td>
                                <td>{{ $schedule->created_at }}</td>
                                <td>
                                    <a data-toggle="tooltip" title="Edit" data-placement="left" href="{{ route('admin.schedule.edit', $assign->id) }}" class="btn btn-info btn-round">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endforeach
</div>
