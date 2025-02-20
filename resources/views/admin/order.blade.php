@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Order Tracking</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Items</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->address }}</td>
                <td>
                    <ul>
                        @foreach(json_decode($order->items) as $item)
                        <li>{{ $item->name }} ({{ $item->quantity }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    @if($order->status == 'pending')
                    <button class="btn btn-success btn-sm accept-order" data-id="{{ $order->id }}">Terima</button>
                    <button class="btn btn-danger btn-sm reject-order" data-id="{{ $order->id }}">Tolak</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('.accept-order').click(function() {
        const orderId = $(this).data('id');
        $.ajax({
            url: `/admin/orders/${orderId}/accept`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                location.reload();
            }
        });
    });

    $('.reject-order').click(function() {
        const orderId = $(this).data('id');
        $.ajax({
            url: `/admin/orders/${orderId}/reject`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                location.reload();
            }
        });
    });
});
</script>
@endsection