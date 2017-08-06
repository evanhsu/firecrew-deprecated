@extends('../layouts.application_layout')

@section('title','Accounts - RescueCircle')


@section('content')
<div class="container-fluid background-container">
    
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
        <h1>Create a New User Account</h1>

        <form action="{{ route('register_user') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">First Name</label>

                <div class="col-sm-6">
                    <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="lastname" class="col-sm-3 control-label">Last Name</label>

                <div class="col-sm-6">
                    <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>

                <div class="col-sm-6">
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Password</label>

                <div class="col-sm-6">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>


    		<div class="form-group">
                <label for="crew_id" class="col-sm-3 control-label sr-only">Crew ID</label>
                <input type="hidden" name="crew_id" id="crew_id" value="{{ $crew_id }}" class="form-control">
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-2">
                    <button type="submit" class="btn btn-default">Create</button>
                </div>
            </div>
        </div>

</div>
@endsection