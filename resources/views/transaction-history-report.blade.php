<table class="table table-hover">
    <thead>
        <tr>
            <th>Transaction Id</th>
            <th>Delivery Method</th>
            <th>Sender Name</th>
            <th>Send Amount</th>
            <th>Recipient Name</th>
            <th>Recipient Amount</th>
            <th>Transfer Status</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @if (is_array($arrReport) && count($arrReport))
            @foreach ($arrReport as $k => $item)
                <tr class="pointer">
                    <td>{{ $item['transaction_id'] }}</td>
                    <td>{{ $item['Delivery_Method'] }}</td>
                    <td>{{ $item['Sender_Name'] }}</td>
                    <td>{{ $item['Send_Amount'] }}</td>
                    <td>{{ $item['Recipient_Name'] }}</td>
                    <td>{{ $item['Recipient_Amount'] }}</td>
                    <td>{{ $item['Transfer_Status'] }}</td>
                    <td>{{ $item['Reason'] }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">No record found</td>
            </tr>
        @endif
    </tbody>
</table>
