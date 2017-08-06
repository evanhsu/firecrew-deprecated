@extends('../layouts.application_layout')

@section('title','RescueCircle')


@section('content')
<div id="container-fluid" class="container-fluid background-container">
    <div class="container form-box">
        <h1>Create New Crew</h1>

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    
        <form action="{{ route('store_crew') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Crew Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="statusable_type" class="col-sm-3 control-label">Crew Type</label>
                <div class="col-sm-6">
                    <select name="statusable_type" id="statusable_type" class="form-control">
                        <option value="Crew">Hotshots</option>
                        <option value="Rappelhelicopter">Rappel</option>
                        <option value="Shorthaulhelicopter">Short Haul</option>
                        <option value="Smokejumperairplane">Smokejumpers</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-2">
                    <button type="submit" class="btn btn-default">Create</button>
                </div>
            </div>
        </form>
    </div>

    
</div>

@endsection