<h2>Location</h2>

<div class="form-group clearfix" style="padding-left: 15px">
    <label for="latitude_deg" class="control-label sr-only">Degrees of Latitude</label>
    <span class="input-group" style="display:inline-table; width: 120px">
        <span class="input-group-addon" style="max-width: 36px">N</span>
        <input
                type="text"
                name="latitude_deg"
                class="form-control"
                style="text-align:right;"
                value="{{ $status->latitude_deg }}"
                placeholder="41"
                aria-label="Latitude (whole degrees)"
        >
        <span class="input-group-addon">&deg;</span>
    </span>
    <span class="input-group" style="display:inline-table; width: 120px">
        <label for="latitude_min" class="control-label sr-only">Minutes of Latitude</label>
        <input
                type="text"
                name="latitude_min"
                class="form-control"
                style="text-align:right;"
                value="{{ $status->latitude_min }}"
                placeholder="12.3456"
                aria-label="Latitude (decimal minutes)"
        >
        <span class="input-group-addon">'</span>
    </span>
</div>
<div class="form-group clearfix" style="margin-bottom: 0; padding-left: 15px">
    <label for="longitude_deg" class="control-label sr-only">Degrees of Longitude</label>
    <span class="input-group" style="display:inline-table; width:120px;">
        <span class="input-group-addon" style="max-width: 36px">W</span>
        <input
                type="text"
                name="longitude_deg"
                class="form-control"
                style="text-align:right;"
                value="{{ $status->longitude_deg }}"
                placeholder="120"
                aria-label="Longitude (whole degrees)"
        >
        <span class="input-group-addon">&deg;</span>
    </span>
    <span class="input-group" style="display:inline-table; width:120px;">
        <label for="longitude_min" class="control-label sr-only">Minutes of Longitude</label>
        <input
                type="text"
                name="longitude_min"
                class="form-control"
                style="text-align:right;"
                value="{{ $status->longitude_min }}"
                placeholder="12.3456"
                aria-label="Longitude (decimal minutes)"
        >
        <span class="input-group-addon">'</span>
    </span>
</div>
<div class="form-group" style="margin-top: -15px; padding-left: 15px;">
    <span class="input-group" style="width:128px;">&nbsp;</span>
    <span>
        <a href="#" class="geolocate_button"><span class="glyphicon glyphicon-map-marker"></span> Use current location</a>
    </span>
</div>