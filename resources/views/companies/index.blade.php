@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h1>Companies</h1>
            <a href="{{ route('companies.create') }}" class="btn btn-primary mt-2">Add Company</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th> ID </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($companies as $company)
                        <tr>
                            <td> {{ $i }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->website }}</td>
                            <td><img src="{{ asset($company->logo) }}" alt="Logo" class="img-fluid"
                                    style="width: 100px;"></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-secondary edit-button" data-company-id="{{ $company->id }}"
                                    data-toggle="modal" data-target="#editCompanyModal">Edit</button>
                                <!-- Delete Form -->
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
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
        <div class="d-flex justify-content-center">
            {{ $companies->links() }}
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCompanyForm" action="{{ route('companies.update', $company->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $company->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $company->email) }}">
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website"
                                value="{{ old('website', $company->website) }}">
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            @if ($company->logo)
                                <div class="mt-2">
                                    <img src="{{ ($company->logo) }}" alt="Company Logo" style="width: 100px;">
                                </div>
                            @endif
                            <small class="form-text text-muted">Leave blank to keep current logo.</small>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Correct Bootstrap modal event for showing the modal is 'show.bs.modal'
            $('#editCompanyModal').on('show.bs.modal', function() {});

            // Existing code
            $('.btn-close, .modal-close').on('click', function() {
                $('#editCompanyModal').modal('hide');
            });

            // Uncommented and corrected your initial AJAX call for completeness
            $('.edit-button').on('click', function() {
                var companyId = $(this).data('company-id');
                var url = `/companies/${companyId}/edit`;

                $.get(url, function(data) {
                    $('#editCompanyModal .modal-body').html(data);
                    $('#editCompanyModal').modal('show');
                });
            });
        });
    </script>
@endsection
