<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Untuk sticky sidebar kiri */
        .sticky-sidebar {
            position: sticky;
            top: 1rem;
        }

        /* Agar tombol tidak dempet */
        .nav-buttons > * {
            margin-left: 0.5rem;
        }

        /* Agar tinggi sidebar ngikutin tampilan */
        .sidebar-container {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    

    <div class="container-fluid">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
