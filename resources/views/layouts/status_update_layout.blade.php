@extends('../layouts.application_layout')

@section('title','Update - RescueCircle')


@section('content')
<div id="container-fluid" class="container-fluid background-container">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="container form-box">
        @yield('form')
    </div>
    
</div>

@endsection


@section('scripts-postload')
@parent

<script>
    (function() {
        // Add geolocation trigger to the 'geolocate_button'
        $('#geolocate_button').click(function() {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Location successfully found
                populatePositionFields(position.coords.latitude, position.coords.longitude);

            }); // End .getCurrentPosition()
        }); // End .click()
    })();

    function populatePositionFields(latitude,longitude) {
        // Coordinate input format is Decimal-degrees with "Easting" longitudes (locations in the western hemisphere have negative longitude).
        // i.e. latitude = 42.389043    longitude = -120.87849
        // Convert this into "westing" decimal-minutes and populate the form with the resulting values (western hemisphere has positive longitude).

        var lat_deg = Math.floor(Math.abs(latitude));   // Use absolute value so that floor() works as desired for negative numbers
        var lat_min = (Math.abs(latitude) - lat_deg) * 60.0;
        lat_deg = latitude >= 0 ? lat_deg : (lat_deg * 1.0); // Restore the original sign

        var lon_deg = Math.floor(Math.abs(longitude)); // Use absolute value so that floor() works as desired for negative numbers
        var lon_min = (Math.abs(longitude) - lon_deg) * 60.0;
        lon_deg = longitude < 0 ? lon_deg : (lon_deg * -1.0); // Switch from 'East' reference to 'West' reference (invert sign)

        $('#latitude_deg').val( lat_deg );
        $('#latitude_min').val( lat_min.toPrecision(6) );

        $('#longitude_deg').val( lon_deg );
        $('#longitude_min').val( lon_min.toPrecision(6) );

    } // End populatePositionFields()

</script>

@endsection