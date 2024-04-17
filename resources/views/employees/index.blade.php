@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h1>Employees</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary mt-2">Add Employee</a>
    </div>

    <!-- Search Form -->
    <div class="mb-3">
        <input type="text" class="form-control" id="searchEmployee" placeholder="Search employees...">
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th> ID </th>
                    <th>Full Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp
                @foreach ($employees as $employee)
                <tr>
                    <td> {{ $i }} </td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->company->name ?? 'N/A' }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>
                    <button class="btn btn-secondary edit-button" data-employee-id="{{ $employee->id }}"
                                    data-toggle="modal" data-target="#editEmployeeModal">Edit</button>
                                <!-- Delete Form -->
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                    </td>
                </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $employees->links() }}
    </div>
</div>
@endsection

    <!-- Modal Structure -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="editEmployeeForm" action="{{ route('employees.update', $employee->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="first_name">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required autofocus>

                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="employee_id">{{ __('Company') }}</label>
                            <select id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>

                            @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $employee->email) }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $employee->phone) }}">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Employee') }}
                                </button>
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // Correct Bootstrap modal event for showing the modal is 'show.bs.modal'
            $('#editEmployeeModal').on('show.bs.modal', function() {});

            // Existing code
            $('.btn-close, .modal-close').on('click', function() {
                $('#editEmployeeModal').modal('hide');
            });

            // Uncommented and corrected your initial AJAX call for completeness
            $('.edit-button').on('click', function() {
                var employeeId = $(this).data('employee-id');
                var url = `/employees/${employeeId}/edit`;
                $.get(url, function(data) {
                    $('#editEmployeeModal .modal-body').html(data);
                    $('#editEmployeeModal').modal('show');
                });
            });
        });
    </script>


<script>
$(document).ready(function() {
    // Example: AJAX for searching employees
    $('#searchEmployee').on('keyup', function() {
        var value = $(this).val();
        // Perform AJAX request based on search value
        // Update the table body with the search result
    });

    // Example: Load employee edit form in modal
    $('.edit-employee').on('click', function() {
        var employeeId = $(this).data('employee-id');
        // Perform AJAX request to get employee edit form
        // Display the form in a modal
    });
});
</script>

@endsection

