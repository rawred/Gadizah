@extends('admin.layout')

@section('content')
    <div class="container-fluid mt-4">
        <h1 class="text-center mb-4">Order Tracking</h1>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Pending Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
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
                                        <ul class="list-unstyled">
                                            @foreach(json_decode($order->items) as $item)
                                                <li>{{ $item->name }} ({{ $item->quantity }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'pending') badge-warning
                                            @elseif($order->status == 'accepted') badge-success
                                                @else badge-danger
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <button class="btn btn-success btn-sm accept-order" data-id="{{ $order->id }}">
                                            <i class="bi bi-check-circle"></i> Accept
                                        </button>
                                         <button class="btn btn-danger btn-sm reject-order" data-id="{{ $order->id }}">
                                            <i class="bi bi-x-circle"></i> Reject
                                         </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.accept-order').click(function () {
                console.log("Accept button clicked!");
                const orderId = $(this).data('id');
                if (confirm('Are you sure you want to accept this order?')) {
                    $.ajax({
                        url: `/admin/orders/${orderId}/accept`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            location.reload();
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });

            $('.reject-order').click(function () {
                console.log("Reject button clicked!");
                const orderId = $(this).data('id');
                if (confirm('Are you sure you want to reject this order?')) {
                    $.ajax({
                        url: `/admin/orders/${orderId}/reject`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            location.reload();
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection