@extends('../layouts.status_update_layout')

@section('form')
    <h1>Status Update</h1>

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"{!! ($tailnumber == "") ? " class=\"active\"" : "" !!}>
                <a href="#intel" aria-controls="intel" role="tab" data-toggle="tab">Intel</a></li>
            </li>
            @foreach($statuses as $status)
                <li role="presentation"{!! ($status->statusable_resource_name == $tailnumber) ? " class=\"active\"" : "" !!}>
                    <a href="#{!! $status->statusable_resource_name !!}" aria-controls="{!! $status->statusable_resource_name !!}" role="tab" data-toggle="tab">
                        {{ $status->statusable_resource_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>


    <div class="tab-content">
        <div role="tabpanel" class="tab-pane{!! ($tailnumber == "") ? " in active" : "" !!}" id="intel">
            Intel panel content
        </div>

        @foreach($statuses as $status)

        <div role="tabpanel" class="tab-pane{!! ($tailnumber == $status->statusable_resource_name) ? " in active" : "" !!}" id="{!! $status->statusable_resource_name !!}">
            @include('freshness_alerts/'.$status->statusable_resource_type, ['freshness' => $status->resource->freshness()])
            @include('status_forms/'.$status->statusable_resource_type)
        </div>

        @endforeach

    </div>
@endsection