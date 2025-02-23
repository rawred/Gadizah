@extends('admin.layout')

@section('content')
    <div class="container-fluid mt-4">
        <h1 class="text-center mb-4">Order Tracking</h1>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Pesanan Yang Pending</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Pemesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Produk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->phone }}</td>
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

        <!-- History Table -->
        <div class="card shadow mt-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">Riwayat Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Pemesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Produk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->phone }}</td>
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