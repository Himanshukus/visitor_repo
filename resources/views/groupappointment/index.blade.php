@extends('layouts/main')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Appointment List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Appointments</a></li>
                            <li class="breadcrumb-item active">Appointment List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Appointment List <span
                            class="text-muted fw-normal ms-2">({{ count($data) ?? 0 }})</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">

                    <div>
                        <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#appointmentgroup"
                            data-bs-whatever="@getbootstrap"><i class="bx bx-plus me-1"></i> Add Group</a>
                    </div>

                </div>
            </div>
        </div>


        <!-- end row -->
        {{-- appointment form --}}




        {{-- appointment group --}}
        <div class="modal fade" id="appointmentgroup" tabindex="-1" aria-labelledby="appointmentgroupLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentgroupLabel">New Group Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="appointmentgroupForm" method="post" action="{{ route('appointmentgroup.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">Name</label>
                                        <input class="form-control" id="choices-text-remove-button" type="text"
                                            value="" placeholder="" name="name" />
                                        <input type="hidden" class="form-control" id="id" name="id"
                                            value="">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="col-form-label">Phone No.</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="col-form-label">Staff</label>
                                        <div class="dropdown  mt-sm-0">
                                            <select class="form-select" name="host_id" id="host_id">
                                                @foreach ($staff as $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="companyname" class="col-form-label">Company Name</label>
                                        <input type="text" class="form-control" id="companyname" name="companyname"
                                            value="">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="col-form-label">Type</label>
                                        <div class="dropdown  mt-sm-0">
                                            <select class="form-select" name="type" id="apttype">
                                                <option value="single">Single</option>
                                                <option value="group">Group</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="visit_date" class="col-form-label">Appointment Date</label>
                                        <input type="text" class="form-control" id="datepicker-range"
                                            name="visit_date">

                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purpose" class="col-form-label">Purpose </label>
                                        <select class="form-select" name="purpose" id="purpose">
                                            @foreach ($visitorpurpose as $key => $val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time" class="col-form-label">Appointment From Time</label>
                                        <input type="text" class="form-control flatpickr-input" id="from-time"
                                            name="fromtime">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time" class="col-form-label">Appointment To Time</label>
                                        <input type="text" class="form-control flatpickr-input" id="to-time"
                                            name="totime">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id=savegoupapt>Save</button>
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
                        <th scope="col">Phone</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Visit Date</th>
                        <th style="width: 80px; min-width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $val)
                        <tr>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->phone }}</td>
                            <td>{{ $val->companyname }}</td>
                            <td>{{ $val->visit_code }}</td>
                            <td>{{ $val->visit_date }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item editappointment" id="editappointment"
                                                data-id="{{ $val->id }}" href="" data-bs-toggle="modal"
                                                data-bs-target="#appointmentgroup">
                                                Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item deleteapt" id="deleteapt"
                                                data-id="{{ $val->id }}" href="">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $data->links() }} --}}
            <!-- end table -->
        </div>
        <!-- end table responsive -->

    </div>

    <script>
        $(document).ready(function() {

            var textRemove = new Choices(
                document.getElementById('choices-text-remove-button'), {
                    delimiter: ',',
                    editItems: true,
                    // maxItemCount: 5,
                    removeItemButton: true,
                }
            );
            $('.deleteapt').click(function(event) {
                event.preventDefault();
                var id = $(this).attr("data-id");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'get',
                    url: '{{ route('delete_appointment') }}',
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


            // save group visitor
            $('#savegoupapt').click(function() {
                event.preventDefault();
                $(this).prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                );
                var formData = new FormData($('#appointmentgroupForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: $('#appointmentgroupForm').attr('action'),
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
                            $('#appointmentgroupForm')[0].reset();
                            location.reload();
                        }
                        console.log('response', response)
                        $('#appointmentgroupForm')[0].reset();

                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting form:', error);
                    }
                });
            });

            $('.editappointment').click(function() {
                event.preventDefault();
                var id = $(this).attr("data-id");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'get',
                    url: '{{ route('getaptByid') }}',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        // console.log("name", data.data.name)
                        $('#id').val(data.data.id);

                        textRemove.setValue([{
                            value: data.data.name,
                            label: data.data.name
                        }]);

                        $('#phone').val(data.data.phone);
                        $('#datepicker-range').val(data.data.visit_date);
                        $('#email').val(data.data.email);
                        $('#purpose').val(data.data.purpose);
                        $('#apttype').val(data.data.type);
                        $('#companyname').val(data.data.companyname);
                        var appointmentTime = data.data.time;
                        var times = appointmentTime.split(' to ');
                        $('#from-time').val(times[0]);
                        $('#to-time').val(times[1]);
                        $('#host_id').val(data.data.host_id);
                    }
                });

            });


        })
    </script>
@endsection
