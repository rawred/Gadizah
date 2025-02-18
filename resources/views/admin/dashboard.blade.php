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
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white p-0 m-0"
                                style="text-decoration: none;">
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
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->id }}</td>
                        <td><img src="{{ asset('storage/uploads/' . $menu->photo) }}" alt="Menu Photo" width="100"></td>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->price }}</td>
                        <td>{{ $menu->description }}</td>
                        <td>{{ $menu->category }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $menu->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $menu->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editMenuForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category" class="form-label">Category</label>
                            <select class="form-control" id="edit_category" name="category" required>
                                <option value="FOOD">Food</option>
                                <option value="BEVERAGE">Beverage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="edit_photo" name="photo">
                            <small class="text-muted">Leave empty to keep existing photo</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addMenuForm" method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel">Add New Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="menuName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="menuName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="menuPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="menuPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="menuDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="menuDescription" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="menuCategory" class="form-label">Category</label>
                            <select class="form-control" id="menuCategory" name="category" required>
                                <option value="FOOD">Food</option>
                                <option value="BEVERAGE">Beverage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="menuPhoto" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="menuPhoto" name="photo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Menu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#menuTable').DataTable();

            $('#addMenuForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('menu.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            // Edit Functionality
            $('.edit-btn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: `/admin/menu/edit/${id}`,
                    type: 'GET',
                    success: function (response) {
                        $('#edit_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_price').val(response.price);
                        $('#edit_description').val(response.description);
                        $('#edit_category').val(response.category);
                        $('#editMenuModal').modal('show');
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Update Functionality
            $('#editMenuForm').on('submit', function (e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = new FormData(this);

                $.ajax({
                    url: `/admin/menu/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            $('.delete-btn').on('click', function () {
                var id = $(this).data('id');
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: `/admin/menu/delete/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            alert('Menu deleted!');
                            location.reload();
                        },
                        error: function (xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>