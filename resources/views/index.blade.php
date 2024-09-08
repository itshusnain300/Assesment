<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Task List</h2>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Form -->
        <form id="filterForm" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="in-progress">In-Progress</option>
                        <option value="completed">Completed</option>
                        <!-- Add more status options as needed -->
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="dueDateFilter" class="form-label">Due Date</label>
                    <input type="date" id="dueDateFilter" class="form-control">
                </div>

            </div>
            <div class=" mb-4 float-end">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i>Add Task</a>
            </div>
        </form>

        <!-- Task Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                @forelse($tasks as $task)
                    <tr data-status="{{ $task->status }}" data-due-date="{{ $task->due_date->format('Y-m-d') }}">
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ $task->due_date->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="me-2"><i
                                        class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No tasks available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#filterForm').on('change', function() {
                var statusFilter = $('#statusFilter').val().toLowerCase();
                var dueDateFilter = $('#dueDateFilter').val();

                $('#taskTableBody tr').each(function() {
                    var taskStatus = $(this).data('status').toLowerCase();
                    var taskDueDate = $(this).data('due-date');

                    var showRow = true;

                    if (statusFilter && taskStatus !== statusFilter) {
                        showRow = false;
                    }

                    if (dueDateFilter && taskDueDate !== dueDateFilter) {
                        showRow = false;
                    }

                    $(this).toggle(showRow);
                });
            });
        });
    </script>
</body>

</html>
