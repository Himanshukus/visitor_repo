@extends('layouts/main')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Appointment Group List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Appointments</a></li>
                            <li class="breadcrumb-item active">Appointment Group List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Appointment Group List <span
                            class="text-muted fw-normal ms-2">({{ count($data) ?? 0 }})</span></h5>
                </div>
            </div>

        </div>


        <!-- end row -->
        {{-- appointment form --}}




        {{-- appointment group --}}

        <div class="table-responsive mb-4">

            <table class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                <thead>
                    <tr>

                       
                        <th scope="col">Company Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Visit Date</th>
                        <th scope="col">Visitor Count</th>
                        <th style="width: 80px; min-width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $val)
                        <tr>
                          
                            <td>{{ $val->companyname }}</td>
                            <td>{{ $val->visit_code }}</td>
                            <td>{{ $val->visit_date }}</td>
                            <td>{{ $val->visitor_count }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" 
                                                data-id="{{ $val->id }}" href="{{route('viewgrpapt',['id'=> $val->visit_code])}}" >
                                                <i class="mdi mdi-eye me-2" ></i>View
                                            </a>
                                        </li>
                                        
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

  
@endsection
