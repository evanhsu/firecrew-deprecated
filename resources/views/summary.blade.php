@extends('../layouts.app')

@section('title', 'Staffing Summary')

@section('content')
    <div id="container-fluid" class="container-fluid background-container">
    <h1>Staffing Summary</h1>

        <table border="1px">
            <thead>
            <tr>
                <th>Crew</th>
                <th>HRAP Surplus</th>
                <th>Resource</th>
                <th>Location</th>
                <th>Notes</th>
                <th>Intel</th>
                <th>Updated</th>
            </tr>
            </thead>

            <tbody>
            @foreach($crews as $crew)
                <?php
                    $rowsToSpan = max(1, count($crew->statusableResources));
                    if($crew->status->personnel_1_name != "") {
                        $rowsToSpan++;
                    }
                    if($crew->status->personnel_2_name != "") {
                        $rowsToSpan++;
                    }
                    if($crew->status->personnel_3_name != "") {
                        $rowsToSpan++;
                    }
                    if($crew->status->personnel_4_name != "") {
                        $rowsToSpan++;
                    }
                    if($crew->status->personnel_5_name != "") {
                        $rowsToSpan++;
                    }
                    if($crew->status->personnel_6_name != "") {
                        $rowsToSpan++;
                    }
                ?>

                @forelse($crew->statusableResources as $resource)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{ $rowsToSpan }}">
                            {{ $crew->name }}<br />
                            {{ $crew->phone }}
                        </td>
                        @endif

                        <td>{{ $resource->latestStatus->staffing_value2 }}</td>
                        <td>
                            {{ $resource->identifier }}
                            @if(!empty($resource->model))
                                ({{ $resource->model }})
                            @endif
                        </td>
                        <td>{{ $resource->latestStatus->assigned_fire_name }}</td>
                        <td>
                            {{ $resource->latestStatus->comments1 }}<br />
                            {{ $resource->latestStatus->comments2 }}
                        </td>

                        @if($loop->first)
                        <td rowspan="{{ $rowsToSpan }}">{{ $crew->status->intel }}</td>
                        <td rowspan="{{ $rowsToSpan }}">{{ $crew->status->created_at }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td rowspan="{{ $rowsToSpan }}">
                            {{ $crew->name }}<br />
                            {{ $crew->phone }}
                        </td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td rowspan="{{ $rowsToSpan }}">{{ $crew->status->intel }}</td>
                        <td rowspan="{{ $rowsToSpan }}">{{ $crew->status->created_at }}</td>
                    </tr>
                @endforelse

                @if($crew->status->personnel_1_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_1_name }}
                            @if(!empty($crew->status->personnel_1_role))
                                ({{ $crew->status->personnel_1_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_1_location }}</td>
                        <td>{{ $crew->status->personnel_1_note}}</td>
                    </tr>
                @endif

                @if($crew->status->personnel_2_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_2_name }}
                            @if(!empty($crew->status->personnel_2_role))
                                ({{ $crew->status->personnel_2_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_2_location }}</td>
                        <td>{{ $crew->status->personnel_2_note}}</td>
                    </tr>
                @endif

                @if($crew->status->personnel_3_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_3_name }}
                            @if(!empty($crew->status->personnel_3_role))
                                ({{ $crew->status->personnel_3_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_3_location }}</td>
                        <td>{{ $crew->status->personnel_3_note}}</td>
                    </tr>
                @endif

                @if($crew->status->personnel_4_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_4_name }}
                            @if(!empty($crew->status->personnel_4_role))
                                ({{ $crew->status->personnel_4_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_4_location }}</td>
                        <td>{{ $crew->status->personnel_4_note}}</td>
                    </tr>
                @endif

                @if($crew->status->personnel_5_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_5_name }}
                            @if(!empty($crew->status->personnel_5_role))
                                ({{ $crew->status->personnel_5_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_5_location }}</td>
                        <td>{{ $crew->status->personnel_5_note}}</td>
                    </tr>
                @endif

                @if($crew->status->personnel_6_name != "")
                    <tr>
                        <td></td>
                        <td>
                            {{ $crew->status->personnel_6_name }}
                            @if(!empty($crew->status->personnel_6_role))
                                ({{ $crew->status->personnel_6_role }})
                            @endif
                        </td>
                        <td>{{ $crew->status->personnel_6_location }}</td>
                        <td>{{ $crew->status->personnel_6_note}}</td>
                    </tr>
                @endif

            @endforeach

            </tbody>
        </table>
@endsection