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
        // Generate WhatsApp message template
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
                                <button type="submit" class="btn btn-primary">COD</button>
                            </form>

                            <hr>

                            <!-- WhatsApp Button -->
                            <button class="btn btn-success"
                                onclick="window.open('https://wa.me/6282136027920?text={{ urlencode($whatsappMessage) }}', '_blank')">
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
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Remove Item
            $('.remove-btn').on('click', function () {
                const id = $(this).data('id');

                if (confirm('Yakin ingin menghapus item ini?')) {
                    $.ajax({
                        url: `/cart/remove/${id}`, // Ensure this matches your route
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log('Remove successful', response);
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function (xhr) {
                            console.error('Remove failed', xhr.responseJSON);
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>