@extends('layouts/main')

@section('content')
    {{-- <div class="container-fluid">

        <section>
            <div class="row p-2">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="card-header"><b>
                                    <h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Update Profile</h4>
                                </b>
                                <h4><b></b></h4>
                            </div>

                            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control" id="name"
                                        value="{{ Auth::user()->name }}" placeholder="Enter Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" type="email" id="email" class="form-control"
                                        value="{{ Auth::user()->email }}" placeholder="Enter Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="imgupload" class="form-label">Upload Image</label>
                                    <input name="imgupload" type="file" class="form-control" id="imgupload"
                                        placeholder="">
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-success">Update Profile</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div> --}}


    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs-custom card-header-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link px-3 active" data-bs-toggle="tab" href="#profile"
                                    role="tab">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" data-bs-toggle="tab" href="#changepassword" role="tab">Change
                                    Password</a>
                            </li>

                        </ul>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="tab-content">
                    <div class="tab-pane active" id="profile" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;Update Profile</h4>
                                    </b>
                                    <h4><b></b>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="pb-3">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @elseif (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('update.profile') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input name="name" type="text" class="form-control" id="name"
                                                    value="{{ Auth::user()->name }}" placeholder="Enter Name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input name="email" type="email" id="email" class="form-control"
                                                    value="{{ Auth::user()->email }}" placeholder="Enter Email">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="date" class="col-form-label">Department</label>
                                                <div class="dropdown ">
                                                    <select class="form-select" name="department_id" id="department_id" disabled>
                                                        @foreach ($department as $val)
                                                        <option value="{{ $val->id }}" {{ Auth::user()->department_id == $val->id ? 'selected' : '' }}>
                                                           {{ $val->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imgupload" class="form-label">Upload Image</label>
                                                <input name="imgupload" type="file" class="form-control" id="imgupload"
                                                    placeholder="">
                                            </div>
                                        </div>
                                            <div class="text-center">
                                                <button class="btn btn-success">Update Profile</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    
                        <!-- end card -->
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane" id="changepassword" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Change Password</h5>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="pb-3">
                                        @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @elseif (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('update.password') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="newPasswordInput" class="form-label">New Password</label>
                                            <input name="new_password" type="password" class="form-control " placeholder="New Password">
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror                                
                                        </div>
                                        <div class="mb-3">  
                                            <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                            <input name="new_password_confirmation" type="password" class="form-control" placeholder="Confirm New Password">
                                        </div>
                                      

                                        <div class="float-end">
                                            <button class="btn btn-success">Update Password</button>
                                        </div>
                                    </form>
                                    </div>

                                    
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end tab pane -->


                    <!-- end tab pane -->
                </div>
                <!-- end tab content -->
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
