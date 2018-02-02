<form action="{{ route('store_status_for_crew', ['crewId' => $crew->id]) }}" method="POST" class="form-horizontal">
    {{ csrf_field() }}


    <div class="col-xs-12 col-md-6">
        <h2>Staffing</h2>
        <div class="form-group">
            <label for="staffing_value1" class="col-xs-4 col-sm-2 control-label">Rappellers</label>
            <div class="col-xs-4 col-sm-2">
                <input type="text" name="staffing_value1" id="staffing_value1" class="form-control"
                       value="">
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