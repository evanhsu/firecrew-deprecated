@extends('../layouts.status_update_layout')

@section('form')
<h1>Rappel Aircraft Status Update</h1>

<nav>
    <ul class="nav nav-tabs" role="tablist">
        @foreach($aircrafts as $a)
        <li role="presentation"{!! ($a->id == $aircraft->id) ? " class=\"active\"" : "" !!}>
            <a href="{{ route('new_status_for_aircraft',$a->tailnumber) }}">{{ $a->tailnumber }}</a>
        </li>
        @endforeach
    </ul>
</nav>
<form action="{{ route('create_status') }}" method="POST" class="form-horizontal">
    @include("status_forms._aircraft_form_headers")
    

    <div class="col-xs-12 col-md-6 form-inline">
        @include("status_forms._fields_for_location")
    </div>
    
    <div class="col-xs-12 col-md-6">
        <h2>Current Assignment</h2>
        <div class="form-group">
            <label for="assigned_fire_name" class="col-xs-4 col-sm-2 control-label">Fire Name</label>
            <div class="col-sm-6">
                <input type="text" name="assigned_fire_name" id="assigned_fire_name" class="form-control" value="{{ $status->assigned_fire_name }}" placeholder="i.e. The Example Fire">
            </div>
        </div>
        <div class="form-group">
            <label for="assigned_fire_number" class="col-xs-4 col-sm-2 control-label">Fire Number</label>
            <div class="col-sm-6">
                <input type="text" name="assigned_fire_number" id="assigned_fire_number" class="form-control" value="{{ $status->assigned_fire_number }}" placeholder="AA-BBB-123456">
            </div>
        </div>
        <div class="form-group">
            <label for="assigned_supervisor" class="col-xs-4 col-sm-2 control-label">Reporting To:</label>
            <div class="col-sm-6">
                <input type="text" name="assigned_supervisor" id="assigned_supervisor" class="form-control" value="{{ $status->assigned_supervisor }}">
            </div>
        </div>
        <div class="form-group">
            <label for="assigned_supervisor_phone" class="col-xs-4 col-sm-2 control-label">Phone</label>
            <div class="col-sm-6">
                <input type="text" name="assigned_supervisor_phone" id="assigned_supervisor_phone" class="form-control" value="{{ $status->assigned_supervisor_phone }}" placeholder="XXX-XXX-XXXX">
            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <h2>Staffing</h2>
        <div class="form-group">
            <label for="staffing_value1" class="col-xs-4 col-sm-2 control-label">Rappellers</label>
            <div class="col-xs-4 col-sm-2 col-md-1">
                <input type="text" name="staffing_value1" id="staffing_value1" class="form-control" value="{{ $status->staffing_value1 }}">
            </div>
        </div>
        <div class="form-group">
            <label for="staffing_value2" class="col-xs-4 col-sm-2 control-label">HRAP Surplus</label>
            <div class="col-xs-4 col-sm-2 col-md-1">
                <input type="text" name="staffing_value2" id="staffing_value2" class="form-control" value="{{ $status->staffing_value2 }}">
            </div>
        </div>
        <div class="form-group">
            <label for="manager_name" class="col-xs-4 col-sm-2 control-label">Manager</label>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <input type="text" name="manager_name" id="manager_name" class="form-control" value="{{ $status->manager_name }}">
            </div>
        </div>
        <div class="form-group">
            <label for="manager_phone" class="col-xs-4 col-sm-2 control-label">Phone</label>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <input type="text" name="manager_phone" id="manager_phone" class="form-control" value="{{ $status->manager_phone }}" placeholder="XXX-XXX-XXXX">
            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <h2>Remarks</h2>
        <div class="form-group">
            <label for="comments1" class="col-xs-4 col-sm-2 control-label">Situation</label>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <textarea name="comments1" id="comments1" class="form-control" rows="4">{{ $status->comments1 }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="comments2" class="col-xs-4 col-sm-2 control-label">Upcoming</label>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <textarea name="comments2" id="comments2" class="form-control" rows="4">{{ $status->comments2 }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </div>
    </div>

</form>
@endsection