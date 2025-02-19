<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                                <img src="{{ asset('storage/uploads/' . $item['photo']) }}" 
                                     alt="{{ $item['name'] }}" 
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>{{ $item['stock'] }}</td>
                            <td>
                                <div class="input-group" style="width: 120px;">
                                    <input type="number" 
                                           class="form-control quantity-input"
                                           data-id="{{ $item['id'] }}"
                                           value="{{ $item['quantity'] }}"
                                           min="1" 
                                           max="{{ $item['stock'] }}">
                                </div>
                            </td>
                            <td>Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-btn" 
                                        data-id="{{ $item['id'] }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <h4>Total Belanja: Rp{{ number_format($total, 0, ',', '.') }}</h4>
            <button class="btn btn-success btn-lg mt-3">Checkout Sekarang</button>
        </div>
    @else
        <div class="alert alert-info">
            Keranjang belanja Anda kosong.
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    $('.quantity-input').on('change', function() {
        const id = $(this).data('id');
        const quantity = $(this).val();
        
        $.ajax({
            url: `/cart/update/${id}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: quantity
            },
            success: function() {
                location.reload();
            }
        });
    });

    $('.remove-btn').on('click', function() {
        const id = $(this).data('id');
        
        if(confirm('Yakin ingin menghapus item ini?')) {
            $.ajax({
                url: `/cart/remove/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });
});
</script>
</body>
</html>