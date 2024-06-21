@extends('layouts/main')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Staff List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                            <li class="breadcrumb-item active">Staff List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Staff List <span
                            class="text-muted fw-normal ms-2">({{ count($data) - 1 ?? 0 }})</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staff"
                            data-bs-whatever="@getbootstrap"><i class="bx bx-plus me-1"></i> Add New</a>
                    </div>

                </div>
            </div>
        </div>


        <!-- end row -->
        {{-- appointment form --}}

        <div class="modal fade" id="staff" tabindex="-1" aria-labelledby="staffLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staffLabel">New Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="staffForm" method="post" action="{{ route('staff.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="">
                                        <input type="hidden" class="form-control" id="id" name="id"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="date" class="col-form-label">Department</label>
                                        <div class="dropdown  mt-sm-0">
                                            <select class="form-select" name="department_id" id="department_id">
                                                @foreach ($department as $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="profile_picture" class="col-form-label">Profile Picture</label>
                                        <input type="file" class="form-control" id="profile_picture"
                                            name="profile_picture" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="image_preview" class="mt-3">

                                        <img id="preview_image" src="#" alt="Preview"
                                            style="max-width: 100%; height: auto; display: none;">
                                        <button type="button" id="remove_image" class="btn btn-sm btn-danger d-none">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id=saveChangesBtn>Save</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive mb-4">

            <table class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                <thead>
                    <tr>

                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th style="width: 80px; min-width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{$data}} --}}
                    @foreach ($data as $val)
                        @php
                            if ($val->name == 'admin') {
                                continue;
                            }
                        @endphp
                        <tr>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->department->name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item editstaff" id="editstaff"
                                                data-id="{{ $val->id }}" href="" data-bs-toggle="modal"
                                                data-bs-target="#staff">
                                                Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item deletstaff" id="deletstaff"
                                                data-id="{{ $val->id }}" href="">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- end table -->
        </div>
        <!-- end table responsive -->

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profilePictureInput = document.getElementById('profile_picture');
            var previewImage = document.getElementById('preview_image');
            var removeImageButton = document.getElementById('remove_image');

            profilePictureInput.addEventListener('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                        removeImageButton.classList.remove('d-none');
                        removeImageButton.style.display = 'inline-block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#';
                    previewImage.style.display = 'none';
                    removeImageButton.style.display = 'none';
                }
            });

            removeImageButton.addEventListener('click', function() {
                previewImage.src = '#';
                previewImage.style.display = 'none';
                removeImageButton.style.display = 'none';
                profilePictureInput.value = '';
            });

        });
    </script>


    <script>
        $(document).ready(function() {

            $('.deletstaff').click(function(event) {
                event.preventDefault();
                var id = $(this).attr("data-id");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'get',
                    url: '{{ route('delete_staff') }}',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.error) {
                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'error'
                            });

                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Deleted Successfully',
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            // location.reload();
                        }

                        location.reload();
                    }
                });

            });

            $('#saveChangesBtn').click(function() {
                event.preventDefault();
                $(this).prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                );
                var formData = new FormData($('#staffForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: $('#staffForm').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                text: response.msg,
                                icon: 'error'
                            });

                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Save Successfully',
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            $('#staffForm')[0].reset();
                            location.reload();
                        }
                        console.log('response', response)
                        $('#staffForm')[0].reset();

                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting form:', error);
                    }
                });
            });

            $('.editstaff').click(function() {
                event.preventDefault();
                var id = $(this).attr("data-id");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'get',
                    url: '{{ route('getstaffByid') }}',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log("asdfasf", data)
                        $('#id').val(data.data.id);
                        $('#name').val(data.data.name);
                        $('#email').val(data.data.email);
                        $('#department_id').val(data.data.department_id);
                        $('#preview_image').attr('src', data.data.profile_picture);
                    }
                });

            });


        })
    </script>
@endsection
