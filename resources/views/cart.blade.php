<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .cart-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .checkout-btn {
            width: 100%;
            padding: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
@php
    $whatsappMessage = "Halo, saya ingin memesan:\n";

    if (isset($cartItems) && count($cartItems) > 0) {
        foreach ($cartItems as $item) {
            $whatsappMessage .= "- {$item['name']} (Qty: {$item['quantity']}) \n";
        }
        $whatsappMessage .= "Total: Rp" . number_format($total, 0, ',', '.') . "\n";
        $whatsappMessage .= "Nama: [NAMA_PEMESAN]\n";
        $whatsappMessage .= "Alamat: [ALAMAT_PENGIRIMAN]";
    } else {
        $whatsappMessage = "Halo, saya ingin bertanya tentang menu yang tersedia";
    }
@endphp

    <div class="container mt-4">
        <div style="display: flex; flex-direction: row; align-items: center; gap: 20px;">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo-1.png') }}" alt="Example Image" style="width: 100px; height: auto;">
            </a>
            <h1 class="mb-4">Keranjang Belanja</h1>
        </div>

        @if(count($cartItems) > 0)
            <div class="row">
                <div class="col-md-8">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('storage/uploads/' . $item['photo']) }}" alt="{{ $item['name'] }}">
                                </div>
                                <div class="col-6">
                                    <h5>{{ $item['name'] }}</h5>
                                    <p class="text-muted">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <div class="col-3 text-end">
                                    <p>Qty: {{ $item['quantity'] }}</p>
                                    <p>Rp{{ number_format($item['total'], 0, ',', '.') }}</p>
                                    <button class="btn btn-danger btn-sm remove-btn" data-id="{{ $item['id'] }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h4>Ringkasan Belanja</h4>
                        <p>Total ({{ count($cartItems) }} items): Rp{{ number_format($total, 0, ',', '.') }}</p>
                        <button class="btn btn-success checkout-btn" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div class="modal fade" id="checkoutModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Metode Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('checkout.cod') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Alamat Pengiriman</label>
                                    <textarea class="form-control" name="address" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>No. Telp (Aktif)</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <button type="submit" class="btn btn-primary">COD</button>
                            </form>
                            <hr>
                            <!-- WhatsApp Button -->
                            <button class="btn btn-success" id="whatsappOrderBtn">
                                WhatsApp Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Keranjang belanja Anda kosong.
            </div>
        @endif

    <!-- Order History Section -->
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
                        <th>Tanggal</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderHistory as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach(json_decode($order->items, true) as $item)
                                        <li>{{ $item['name'] }} ({{ $item['quantity'] }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                Rp{{ number_format(array_reduce(json_decode($order->items, true), function($carry, $item) {
                                    return $carry + ($item['price'] * $item['quantity']);
                                }, 0), 0, ',', '.') }}
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

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // WhatsApp Order Button Click
            $('#whatsappOrderBtn').on('click', function () {
                if (confirm('Are you sure you want to place this order via WhatsApp? This will clear your cart.')) {
                    // Clear the cart and update stock via AJAX
                    $.ajax({
                        url: '{{ route("cart.clear") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                // Redirect to WhatsApp after clearing the cart
                                window.open('https://wa.me/6282136027920?text={{ urlencode($whatsappMessage) }}', '_blank');
                            } else {
                                alert('Failed to clear cart. Please try again.');
                            }
                        },
                        error: function (xhr) {
                            console.error('Error clearing cart:', xhr.responseJSON);
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>