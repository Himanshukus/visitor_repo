@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">App</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <hr class="m-0" />
    <div class="p-4">
        <h2 class="mb-4">Visitor Badge Settings</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Field Visibility</h3>
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @foreach ($data as $field)
                            <div class="form-check mb-3">
                                <input class="form-check-input fieldCheckbox" type="checkbox" id="checkbox{{ $field->id }}" name="fields[{{ $field->field_name }}]" data-field="{{ $field->field_name }}" {{ $field->is_enabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkbox{{ $field->id }}">{{ $field->field_name }}</label>
                            </div>
                            @endforeach
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
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Badge Preview</h3>
                        <div class="preview bg-light p-3">
                            <div class="badge" id="badgePreview">
                                <!-- Badge fields will be dynamically added/removed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const badgePreview = document.getElementById('badgePreview');
        const fieldCheckboxes = document.querySelectorAll('.fieldCheckbox');

        function updateBadgePreview() {
            badgePreview.innerHTML = '';

            fieldCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const fieldName = checkbox.getAttribute('data-field');
                    const fieldElement = document.createElement('div');
                    fieldElement.classList.add('field', 'mb-2', 'px-2', 'py-1', 'bg-primary',
                        'text-white', 'rounded');
                    fieldElement.textContent = fieldName;
                    badgePreview.appendChild(fieldElement);
                }
            });
        }
        updateBadgePreview();
        fieldCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBadgePreview);
        });
    });
</script>
@endsection