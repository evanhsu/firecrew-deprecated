<form
        action="{{ route('store_status_for_crew', ['crewId' => $crew->id]) }}"
        method="POST"
        class="form"
        style="padding:25px"
>
    {{ csrf_field() }}

    <div class="row">
        <h2>Duty Officer</h2>
        <div class="form-group row">
            <label for="duty_officer_name" class="col-sm-2 col-md-1 control-label">Name</label>
            <div class="col-sm-4 col-md-4">
                <input type="text" name="duty_officer_name" id="duty_officer_name" class="form-control"
                       value="{{ $status->duty_officer_name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="duty_officer_phone" class="col-sm-2 col-md-1 control-label">Phone</label>
            <div class="col-sm-4 col-md-4">
                <input type="text" name="duty_officer_phone" id="duty_officer_phone" class="form-control"
                       value="{{ $status->duty_officer_phone }}" placeholder="XXX-XXX-XXXX">
            </div>
        </div>
    </div>

    <div class="row">
        <h2>Crew Intel</h2>
        <div class="form-group">
            <label for="intel" class="control-label sr-only">Crew Intel</label>
            <div class="col-xs-12">
                <textarea name="intel" id="intel" class="form-control"
                          rows="4">{{ $status->intel }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
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