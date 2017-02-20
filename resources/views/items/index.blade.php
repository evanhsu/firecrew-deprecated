@extends('layouts.app')

@section('content')
<div id="inventory" class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <div class="panel-heading">Categories</div>
            <div id="category-menu" class="panel-body"></div>
        </div>
        <div class="col-md-9 col-lg-10" style="overflow: hidden;">
            <div class="panel panel-default">
                <div class="panel-heading">Inventory</div>
                <div id="items-table" class="panel-body"></div>
            </div>
        </div>
    </div>
</div>
<div id="loading-indicator"></div>
@endsection
