<div class="mb-3">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addGalleryModal">
        <i class="fas fa-plus"></i> Add New Gallery/Album
    </button>
</div>

<!-- Galleries List -->
@forelse($property->galleries as $gallery)
<div class="card mb-3" data-gallery-id="{{ $gallery->Id }}">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-folder"></i> {{ $gallery->Title }}
            <span class="badge badge-info float-right">{{ $gallery->getImagesCount() }} images</span>
        </h5>
        @if($gallery->Description)
            <small class="text-muted">{{ $gallery->Description }}</small>
        @endif
    </div>
    <div class="card-body">
        <!-- Upload Images Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-sm btn-primary upload-images-btn" data-gallery-id="{{ $gallery->Id }}">
                <i class="fas fa-upload"></i> Upload Images
            </button>
        </div>

        <!-- Images Grid -->
        <div class="row" id="gallery-{{ $gallery->Id }}-images">
            @forelse($gallery->images as $image)
            <div class="col-md-2 mb-3" data-image-id="{{ $image->Id }}">
                <div class="card">
                    <img src="{{ $image->getImageUrl() }}" class="card-img-top" alt="{{ $image->ImageTitle }}" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-2">
                        @if($image->ImageTitle)
                            <p class="card-text small mb-1">{{ Str::limit($image->ImageTitle, 20) }}</p>
                        @endif
                        <div class="btn-group btn-group-sm d-flex" role="group">
                            @if($image->isDefault())
                                <button type="button" class="btn btn-success btn-sm flex-fill" disabled>
                                    <i class="fas fa-star"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-secondary btn-sm set-default-btn flex-fill" 
                                        data-image-id="{{ $image->Id }}" title="Set as Default">
                                    <i class="far fa-star"></i>
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-sm delete-image-btn flex-fill" 
                                    data-image-id="{{ $image->Id }}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-3">
                No images in this gallery yet.
            </div>
            @endforelse
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> No galleries found. Click "Add New Gallery/Album" to create one and start uploading photos.
</div>
@endforelse

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Gallery/Album</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addGalleryForm">
                @csrf
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="galleryTitle" class="required">Gallery Title</label>
                        <input type="text" name="Title" id="galleryTitle" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="galleryDescription">Description</label>
                        <textarea name="Description" id="galleryDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Images Modal -->
<div class="modal fade" id="uploadImagesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Images</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="uploadImagesForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="uploadGalleryId" name="galleryId">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="imageFiles">Select Images (you can select multiple)</label>
                        <input type="file" name="images[]" id="imageFiles" class="form-control-file" 
                               accept="image/*" multiple required>
                        <small class="form-text text-muted">Accepted formats: JPEG, PNG, GIF (Max: 2MB each)</small>
                    </div>

                    <div class="form-group">
                        <label for="imageTitle">Image Title (applies to all)</label>
                        <input type="text" name="ImageTitle" id="imageTitle" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="imageDescription">Image Description (applies to all)</label>
                        <textarea name="Description" id="imageDescription" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="displayInGallery" 
                                   name="display_in_gallery" value="1" checked>
                            <label class="custom-control-label" for="displayInGallery">Display in Gallery</label>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="row mt-3"></div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Images
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    // Add Gallery
    $('#addGalleryForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("admin.properties.galleries.store", $property->Id) }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    $('#addGalleryModal').modal('hide');
                    location.reload(); // Reload to show new gallery
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    showError(errorMsg);
                } else {
                    showError('An error occurred while creating gallery.');
                }
            }
        });
    });

    // Show upload images modal
    $(document).on('click', '.upload-images-btn', function() {
        let galleryId = $(this).data('gallery-id');
        $('#uploadGalleryId').val(galleryId);
        $('#uploadImagesModal').modal('show');
    });

    // Preview images before upload
    $('#imageFiles').on('change', function() {
        let files = this.files;
        let preview = $('#imagePreview');
        preview.empty();

        if(files.length > 0) {
            $.each(files, function(i, file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(`
                        <div class="col-md-3 mb-2">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 100px; object-fit: cover;">
                            <small class="d-block text-center">${file.name}</small>
                        </div>
                    `);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // Upload Images
    $('#uploadImagesForm').on('submit', function(e) {
        e.preventDefault();
        
        let galleryId = $('#uploadGalleryId').val();
        let formData = new FormData(this);
        let url = '{{ route("admin.galleries.images.upload", ":id") }}'.replace(':id', galleryId);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    $('#uploadImagesModal').modal('hide');
                    location.reload(); // Reload to show new images
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    showError(errorMsg);
                } else {
                    showError('An error occurred while uploading images.');
                }
            }
        });
    });

    // Delete Image
    $(document).on('click', '.delete-image-btn', function() {
        if(!confirm('Are you sure you want to delete this image?')) return;
        
        let imageId = $(this).data('image-id');
        let url = '{{ route("admin.galleries.images.delete", ":id") }}'.replace(':id', imageId);
        let $imageDiv = $('[data-image-id="' + imageId + '"]');
        
        $.ajax({
            url: url,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    $imageDiv.remove();
                }
            },
            error: function(xhr) {
                showError('An error occurred while deleting image.');
            }
        });
    });

    // Set Default Image
    $(document).on('click', '.set-default-btn', function() {
        let imageId = $(this).data('image-id');
        let url = '{{ route("admin.galleries.images.set-default", ":id") }}'.replace(':id', imageId);
        
        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    location.reload(); // Reload to update default status
                }
            },
            error: function(xhr) {
                showError('An error occurred while setting default image.');
            }
        });
    });

    // Reset upload form when modal closes
    $('#uploadImagesModal').on('hidden.bs.modal', function() {
        $('#uploadImagesForm')[0].reset();
        $('#imagePreview').empty();
    });

    // Reset add gallery form when modal closes
    $('#addGalleryModal').on('hidden.bs.modal', function() {
        $('#addGalleryForm')[0].reset();
    });
</script>
@endpush
