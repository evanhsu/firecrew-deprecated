<table>
    <tr>
        <th>Serial #</th>
        <th>Category</th>
        <th>Size</th>
        <th>Color</th>
        <th>Description</th>
        <th>Checkout Out To</th>
        <th>Condition</th>
        <th>Usable</th>
        <th>Note</th>
        <th></th>
        <th></th>
        <th>Modified At</th>
    </tr>

    @foreach($items as $item)
    <tr>
        <td>{{ $item['serial_number'] }}</td>
        <td>{{ $item['category'] }}</td>
        <td>{{ $item['size'] }}</td>
        <td>{{ $item['color'] }}</td>
        <td>{{ $item['description'] }}</td>
        <td>{{ $item['checked_out_to'] ? $item->checked_out_to->full_name : '' }}</td>
        <td>{{ $item['condition'] }}</td>
        <td>{{ $item['usable'] ? "Yes" : "No" }}</td>
        <td>{{ $item['note'] }}</td>
        <td></td>
        <td></td>
        <td>{{ $item['updated_at'] }}</td>
    </tr>
    @endforeach

</table>
