@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Property: {{ $property->PropertyName }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="propertyTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="main-tab" data-toggle="tab" href="#main" role="tab">
                                <i class="fas fa-home"></i> Main Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab">
                                <i class="fas fa-info-circle"></i> General Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab">
                                <i class="fas fa-file-alt"></i> Additional Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="floorplans-tab" data-toggle="tab" href="#floorplans" role="tab">
                                <i class="fas fa-money-bill"></i> Rent & Specials
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab">
                                <i class="fas fa-images"></i> Photos
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="main" role="tabpanel">
                            @include('admin.property.edit._tab_main_details')
                        </div>
                        <div class="tab-pane fade" id="general" role="tabpanel">
                            @include('admin.property.edit._tab_general_details')
                        </div>
                        <div class="tab-pane fade" id="additional" role="tabpanel">
                            @include('admin.property.edit._tab_additional_details')
                        </div>
                        <div class="tab-pane fade" id="floorplans" role="tabpanel">
                            @include('admin.property.edit._tab_floor_plans')
                        </div>
                        <div class="tab-pane fade" id="photos" role="tabpanel">
                            @include('admin.property.edit._tab_photos')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .nav-tabs .nav-link {
        color: #495057;
    }
    .nav-tabs .nav-link.active {
        font-weight: bold;
    }
    .form-group label {
        font-weight: 600;
    }
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote for all textareas with class 'summernote'
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Show success messages
        window.showSuccess = function(message) {
            alert(message); // Replace with your preferred notification library
        };

        // Show error messages
        window.showError = function(message) {
            alert('Error: ' + message); // Replace with your preferred notification library
        };
    });
</script>
@endpush
