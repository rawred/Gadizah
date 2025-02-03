<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-white p-0 m-0" style="text-decoration: none;">
                        Logout
                    </button>
                    </form>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        <h1 class="text-center">Menu Management</h1>

        <!-- Add New Menu Modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMenuModal">Add New Menu</button>

        <table id="menuTable" class="display table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($menus as $menu)
            <tr id="menuRow{{ $menu->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}" width="100">
                </td>
                <td>{{ $menu->name }}</td>
                <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $menu->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm delete-menu" data-id="{{ $menu->id }}">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>

   <!-- Edit Menu Modal -->
@foreach($menus as $menu)
<div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form method="POST" action="{{ route('menu.update', $menu->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
    <label for="menuName{{ $menu->id }}" class="form-label">Name</label>
    <input type="text" class="form-control" id="menuName{{ $menu->id }}" name="name" value="{{ $menu->name }}" required>
    </div>
    <div class="mb-3">
    <label for="menuPrice{{ $menu->id }}" class="form-label">Price</label>
    <input type="number" class="form-control" id="menuPrice{{ $menu->id }}" name="price" value="{{ $menu->price }}" required>
    </div>
    <div class="mb-3">
    <label for="menuPhoto{{ $menu->id }}" class="form-label">Photo</label>
    <input type="file" class="form-control" id="menuPhoto{{ $menu->id }}" name="photo">
    </div>
    <button type="submit" class="btn btn-primary">Add Menu</button>
</form>
    </div>
</div>
@endforeach


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
$('#addMenuForm').submit(function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    
    $.ajax({
        url: "{{ route('menu.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#menuTable tbody').append(`
                <tr id="menu-${response.id}">
                    <td>${response.id}</td>
                    <td><img src="/storage/${response.photo}" width="100"></td>
                    <td>${response.name}</td>
                    <td>Rp ${response.price.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-menu" data-id="${response.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-menu" data-id="${response.id}">Delete</button>
                    </td>
                </tr>
            `);
            $('#addMenuModal').modal('hide');
            $('#addMenuForm')[0].reset(); // Reset the form
        },
        error: function(xhr) {
            alert("Failed to add menu: " + xhr.responseText);
        }
    });
});

$(document).on('click', '.delete-menu', function() {
    let id = $(this).data('id');
    $.ajax({
        url: `/menu/${id}`,
        type: "DELETE",
        data: {_token: "{{ csrf_token() }}"},
        success: function() {
            $(`#menu-${id}`).remove();
        }
    });
});

</script>
<!-- Place this just before closing </body> -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">Add New Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMenuForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="menuName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="menuName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="menuPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="menuPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="menuPhoto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="menuPhoto" name="photo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Menu</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
