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
	    @include('auth._users_table')

	    <div class="dropdown">

			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Create a New User for...
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				@foreach($crews as $crew)
					<li><a href="{{ route('new_user_for_crew', $crew->id) }}">{{ $crew->name }}</a></li>
				@endforeach
			</ul>
		</div>

	</div>

</div>
@endsection