<form action="{{ route('store_status_for_crew', ['crewId' => $crew->id]) }}" method="POST"
      class="form-horizontal">
    {{ csrf_field() }}

    <div class="col-xs-12">
        <h2>Crew Intel</h2>
        <div class="form-group">
            <label for="intel" class="control-label sr-only">Crew Intel</label>
            <div class="col-xs-12">
                <textarea name="intel" id="intel" class="form-control"
                          rows="4">{{ $status->intel }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <h2>Personnel Assignments</h2>
    </div>

    @for ($i = 1; $i <= 6; $i++)
        @include('status_forms/_fields_for_personnel_assignment')
    @endfor

    <div class="col-xs-12">
        <div class="form-group">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </div>
    </div>

</form>