<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h1 class="mb-4">Keranjang Belanja</h1>

        @if(count($cartItems) > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok Tersedia</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/uploads/' . $item['photo']) }}" alt="{{ $item['name'] }}"
                                        style="width: 80px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>{{ $item['stock'] }}</td>
                                <td>
                                    <!-- Display quantity as a static number -->
                                    <span>{{ $item['quantity'] }}</span>
                                </td>
                                <td>Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-btn" data-id="{{ $item['id'] }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Checkout Button -->
            <div class="text-end mt-4">
                <h4>Total Belanja: Rp{{ number_format($total, 0, ',', '.') }}</h4>
                <button class="btn btn-success btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    Checkout Sekarang
                </button>
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