<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <a class="navbar-brand mx-2" href="#">Task Manager</a>
    </nav>

    <!-- Container for content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="mb-4">Welcome to Task Manager</h1>
                <p class="lead mb-5">Manage your tasks efficiently.</p>
                <a href="{{route('tasks.index')}}" class="btn btn-primary btn-lg mb-3">
                    <i class="bi bi-list-task"></i> All Tasks
                </a>
                <br>
                <a href="{{route('tasks.create')}}" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle"></i> Create Task
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
