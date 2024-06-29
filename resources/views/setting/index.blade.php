@extends('layouts/main')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Setting</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">App</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>



        <!-- Settings -->
        <hr class="m-0" />

        <div class="p-4">
            {{-- <h6 class="mb-3">Layout</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout" id="layout-vertical" value="vertical">
                <label class="form-check-label" for="layout-vertical">Vertical</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout" id="layout-horizontal" value="horizontal">
                <label class="form-check-label" for="layout-horizontal">Horizontal</label>
            </div> --}}
            <h6 class="mt-4 mb-3 pt-2">Manage App Background</h6>

            <div class="mb-3">
                <select class="form-select">
                    <option>Select</option>
                    <option value="video">Video</option>
                    <option value="image">Image</option>
                    <option value="plaincolor">Plain Color</option>
                    <option value="Gradient">Gradient</option>

                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary w-md">Submit</button>
            </div>
        </div>



        <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
