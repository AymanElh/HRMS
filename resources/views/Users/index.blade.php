@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Employee Management</h2>

        <!-- Button to open modal -->
        <button class="btn btn-primary mb-3" onclick="openModal()">Add Employee</button>

        <!-- Success Message -->
        <div id="success-message" class="alert alert-success d-none"></div>

        <!-- Employees Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="employees-table">
            @foreach ($users as $user)
                <tr id="row-{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editEmployee({{ $user->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteEmployee({{ $user->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>

    <!-- Modal -->
    <div id="employeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-title">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="employee-form">
                        <input type="hidden" id="user_id">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control">
                            <span class="text-danger" id="error-name"></span>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" id="email" class="form-control">
                            <span class="text-danger" id="error-email"></span>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select id="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="employee">Employee</option>
                            </select>
                            <span class="text-danger" id="error-role"></span>
                        </div>
                        <button type="button" onclick="saveEmployee()" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("employee-form").reset();
            document.getElementById("modal-title").innerText = "Add Employee";
            document.getElementById("user_id").value = "";
            new bootstrap.Modal(document.getElementById('employeeModal')).show();
        }

        function saveEmployee() {
            let id = document.getElementById("user_id").value;
            let url = id ? `/dashboard/users/${id}` : "/dashboard/users";
            let method = id ? "PUT" : "POST";

            fetch(url, {
                method: method,
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({
                    name: document.getElementById("name").value,
                    email: document.getElementById("email").value,
                    role: document.getElementById("role").value
                })
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("success-message").classList.remove("d-none");
                    document.getElementById("success-message").innerText = data.message;
                    location.reload();
                })
                .catch(err => console.error(err));
        }

        function deleteEmployee(id) {
            fetch(`/dashboard/users/${id}`, { method: "DELETE", headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content } })
                .then(() => location.reload());
        }
    </script>
@endsection
