@php 
    $checkedOutItemsExist = false;
@endphp

<table>
    <tr>
        <th>Id</th>
        <th>QTY</th>
        <th>Category</th>
        <th>Size</th>
        <th>Color</th>
        <th>Description</th>
        <th>Min Qty</th>
        <th>Restock To</th>
        <th>Source</th>
        <th>Note</th>
        <th></th>
        <th></th>
        <th>Modified At</th>
    </tr>

    @foreach($items as $item)
        @if(!$item->checked_out_to)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['category'] }}</td>
                <td>{{ $item['size'] }}</td>
                <td>{{ $item['color'] }}</td>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['restock_trigger'] }}</td>
                <td>{{ $item['restock_to_quantity'] }}</td>
                <td>{{ $item['source'] }}</td>
                <td>{{ $item['note'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $item['updated_at'] }}</td>
            </tr>
        @else
            @php 
            $checkedOutItemsExist = true;
            @endphp
        @endif
    @endforeach

    @if($checkedOutItemsExist)
        <tr>
            <th>Id</th>
            <th>QTY</th>
            <th>Category</th>
            <th>Size</th>
            <th>Color</th>
            <th>Description</th>
            <th>Checked Out To</th>
            <th>Condition</th>
            <th>Usable</th>
            <th>Note</th>
            <th></th>
            <th></th>
            <th>Modified At</th>
        </tr>

        @foreach($items as $item)
            @if($item->checked_out_to)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['category'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td>{{ $item['color'] }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item->checked_out_to->full_name }}</td>
                    <td>{{ $item['condition'] }}</td>
                    <td>{{ $item['usable'] }}</td>
                    <td>{{ $item['note'] }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $item['updated_at'] }}</td>
                </tr>
            @endif
        @endforeach

    @endif

</table>
