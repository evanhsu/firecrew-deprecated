@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @foreach($categories as $category => $items)
                        @if($items->first()->type == 'accountable')
                            @include('items._accountableItemsTable')
                        @else
                            @include('items._bulkItemsTable')
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
