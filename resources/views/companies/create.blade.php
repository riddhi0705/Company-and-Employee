@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-center mb-4">Add New Company</h2>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Company Creation Form -->
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" id="companyForm">
                @csrf
                <div class="form-group">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}">
                </div>

                <div class="form-group">
                    <label for="logo">Logo <small class="form-text text-muted">(Must be at least 100x100 pixels)</small></label>
                    <input type="file" class="form-control-file" id="logo" name="logo">
                </div>

                <button type="submit" class="btn btn-primary">Create Company</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        // Make sure to include the validation script for those who might skip including in the layout
        $('#companyForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    email: true
                },
                website: {
                    url: true
                },
                logo: {
                    extension: "jpg|jpeg|png|gif",
                    filesize: 1048576 // 1MB
                }
            },
            messages: {
                name: {
                    required: "Please enter the company name",
                    maxlength: "The company name must be less than 255 characters"
                },
                email: "Please enter a valid email address",
                website: "Please enter a valid URL",
                logo: {
                    extension: "Only image files are allowed",
                    filesize: "File size must be less than 1MB"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, "File size must be less than 1MB");
    });
</script>
@endsection
