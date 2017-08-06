<?php
// views/map_popups/local/rappelhelicopter.blade.php
//
// This file contains the HTML that will be displayed in a popup box when a Rappel Helicopter
// feature is clicked on the ResourceBeacon map.
//
// $status is a Status object that must be passed to this view by the controller.
?>
<table class="popup-table">
    <tr>
        <td class="logo-cell" aria-label="Logo" title="Crew Logo">
            <img src="{{ $crew->logo_filename }}"/>
        </td>

        <td aria-label="Aircraft Info" title="Current manager & aircraft info">
            <div class="popup-col-header"><span class="glyphicon glyphicon-plane"></span> HMGB</div>
            {{ $status->manager_name }}<br />
            {{ $status->manager_phone }}
        </td>

        <td aria-label="Current Staffing" title="Current staffing levels">
            <div class="popup-col-header"><span class="glyphicon glyphicon-user"></span> Staffing</div>
            <table class="staffing_table">
                <tr><td>HRAP:</td><td>{{ $status->staffing_value1 }}</td></tr>
                <tr><td>Surplus:</td><td>{{ $status->staffing_value2 }}</td></tr>
            </table>
        </td>

        <td aria-label="Current Assignment" title="Current assignment & supervisor">
            <div class="popup-col-header"><span class="glyphicon glyphicon-map-marker"></span> Assigned</div>
            {{ $status->assigned_fire_name }}<br />
            {{ $status->assigned_fire_number }}<br />
            {{ $status->assigned_supervisor }}<br />
            {{ $status->assigned_supervisor_phone }}</td>
    </tr>
    <tr>
        <td class="timestamp-cell" colspan="4">Updated: {{ date('m-d-Y H:m', strtotime($status->created_at)) }}</td>
    </tr>
</table>