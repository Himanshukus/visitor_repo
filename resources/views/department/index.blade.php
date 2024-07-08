@extends('layouts/main')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Department List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Departments</a></li>
                            <li class="breadcrumb-item active">Department List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Department List <span class="text-muted fw-normal ms-2">({{ count($data) ?? 0 }}
                            )</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#department"
                            data-bs-whatever="@getbootstrap"><i class="bx bx-plus me-1"></i> Add New</a>
                    </div>

                </div>
            </div>
        </div>


        <!-- end row -->
        {{-- department form --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="modal fade" id="department" tabindex="-1" aria-labelledby="departmentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="departmentLabel">New Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="departmentForm" method="post" action="{{ route('department.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="">
                                <input type="hidden" class="form-control" id="id" name="id" value="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table align-middle datatable dt-responsive table-check nowrap"
            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $val)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $val->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item editdepartment" id="editdepartment"
                                            data-id="{{ $val->id }}" href="" data-bs-toggle="modal"
                                            data-bs-target="#department">
                                            Edit
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('deletedepartment', ['id' => $val->id]) }}">Delete</a></li>
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
    @if (Session::has('sa-success'))
        <script>
            Swal.fire(
                'Success!',
                '{{ Session::get('
                            sa - success ') }}',
                'success'
            );
            setTimeout(function() {
                location.reload();
            }, 1000);
        </script>
    @endif

    @if (Session::has('sa-error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ Session::get('
                            sa - error ') }}',
                'error'
            );
            setTimeout(function() {
                location.reload();
            }, 2000);
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#saveChangesBtn').click(function() {
                event.preventDefault();
                var formData = new FormData($('#departmentForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: $('#departmentForm').attr('action'),
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
                            $('#departmentForm')[0].reset();
                            location.reload();
                        }
                        console.log('response', response)
                        $('#departmentForm')[0].reset();

                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting form:', error);
                    }
                });
            });


            $('.editdepartment').click(function() {
                event.preventDefault();
                var id = $(this).attr("data-id");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'get',
                    url: '{{ route('getdepartmentByid') }}',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        $('#id').val(data.data.id);
                        $('#name').val(data.data.name);

                    }
                });

            });
        })
    </script>
@endsection
