<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BananaYello Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .navbar-custom {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <h4 class="text-center">BananaYello</h4>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('df-invoice') }}">DF Invoice Data</a>
        <a href="{{ route('approved-coogs') }}">Approved Coogs Data</a>
        <a href="{{ route('po-invoice') }}">PO Invoice Data</a>
        <a href="{{ route('remittance') }}">Remittance Data</a>
        <a href="{{ route('return-data') }}">Return Data</a>
        <a href="{{ route('coogs') }}">Coogs Data</a>
        <a href="{{ route('users') }}">Users</a>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="navbar-custom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Admin</h5>
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="32" height="32" class="rounded-circle">
            </div>
        </div>

        {{-- Page Content --}}
        <div class="mt-4">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
