<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management </title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: rgba(178, 235, 242, 0.42);
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #0288d1, #01579b) !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0288d1, #01579b);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0277bd, #014c8c);
        }
        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dataTables_wrapper {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 18px;
            }
            .floating-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: center;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#" style="color: yellow">Nabeeh</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Tasks</a> </li>
                <li class="nav-item"><button type="button" class="nav-link active" id="logoutButton"> |  Logout</button></li>

            </ul>
        </div>
    </div>
</nav>


<div class="container">
    <h2 class="mt-4">Task Management</h2>

    <table id="tasks-table" class="table table-striped mt-4">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<button class="btn btn-primary floating-btn" data-bs-toggle="modal" data-bs-target="#taskModal">
    <i class="fas fa-plus"></i>
</button>

<!--Start Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Add / Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm">
                    <input type="hidden" id="taskId">
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status">
                            <option value="To-Do">To-Do</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Save Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--END Task Modal -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>
    $(document).ready(function() {
        let authToken = localStorage.getItem('auth_token');


        $.ajaxSetup({
            headers: {
                'Authorization': 'Bearer ' + authToken, //here I pass auth token
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        //datatable
        let table = $('#tasks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("web.tasks.index") }}',
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + authToken
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <button class="btn btn-sm btn-primary edit-task" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger delete-task" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                `;
                    }
                }
            ]
        });


        //send or update task data
        $('#taskForm').submit(function(e) {
            e.preventDefault();

            let id = $('#taskId').val();
            let url = id ? `{{ route('tasks.update', '') }}/${id}` : '{{ route("tasks.store") }}';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                headers: { 'Authorization': 'Bearer ' + authToken },
                data: {
                    title: $('#title').val(),
                    description: $('#description').val(),
                    status: $('#status').val()
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#taskModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'Please try again'
                    });
                }
            });
        });
        $(document).on('click', '.edit-task', function() {
            let id = $(this).data('id');

            $.ajax({
                url: `{{ route('tasks.show', '') }}/${id}`,
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + authToken },
                success: function(task) {
                    $('#taskId').val(task.data.id);
                    $('#title').val(task.data.title);
                    $('#description').val(task.data.description);
                    $('#status').val(task.data.status);
                    $('#taskModal').modal('show');
                }
            });
        });
        $(document).on('click', '.delete-task', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to return  !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('tasks.destroy', '') }}/${id}`,
                        type: 'DELETE',
                        headers: { 'Authorization': 'Bearer ' + authToken },
                        success: function(response) {
                            Swal.fire(
                                "Deleted!",
                                "The task has been deleted.",
                                "success"
                            );
                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire("Error!", "An error occurred while deleting.", "error");
                        }
                    });
                }
            });
        });
        $('#taskModal').on('hidden.bs.modal', function() {
            $('#taskForm')[0].reset();
            $('#taskId').val('');
        });

        //when click on logout btn
        $('#logoutButton').click(function() {


            $.ajax({
                url: '{{ route("api.logout") }}',
                type: "POST",
                headers: {
                    "Authorization": "Bearer " + authToken,
                },
                success: function(response) {
                    localStorage.removeItem("api_token");

                    Swal.fire({
                        icon: 'success',
                        title: 'Logged out successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });


                    window.location.href = "/login";
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Logout failed',
                        text: 'Please try again'
                    });
                }
            });
        });

    });

</script>




</body>
</html>
