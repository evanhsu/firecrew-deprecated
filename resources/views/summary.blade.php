@extends('./layouts.app')

@section('title', 'Staffing Summary')

@section('content')
    <div id="react-root"></div>
@endsection

@section('scripts-postload')
    @parent
    <script src="{{ mix('/js/app.js') }}"></script>
@endsection

