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
                <!-- Example Row -->
                <tr>
                    <td>1</td>
                    <td><img src="https://via.placeholder.com/100" alt="Menu Photo" width="100"></td>
                    <td>Example Dish</td>
                    <td>$10</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                <!-- More rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>

    <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
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
        $(document).ready(function() {
            $('#menuTable').DataTable();
        });
    </script>
</body>
</html>
