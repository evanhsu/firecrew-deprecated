@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <div class="panel-heading">Categories</div>

            <div class="panel-body">
                <ul>
                @foreach($categories as $category => $items)
                    <li><a href="#">{{ $category }}</a></li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-lg-10" style="overflow: hidden;">
            <div class="panel panel-default">
                <div class="panel-heading">Inventory</div>

                <div class="panel-body">
                    <table class="table table-hover table-condensed" style="table-layout: fixed; width: 100%; font-size: 0.9em">
                        @foreach($categories as $category => $items)
                            @if($items->first()->type == 'accountable')
                                @include('items._accountableItemsTable')
                            @else
                                @include('items._bulkItemsTable')
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
