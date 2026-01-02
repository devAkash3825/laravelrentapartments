<form id="generalDetailsForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Community Description -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="CommunityFeatures">Community Description</label>
                <textarea name="CommunityFeatures" id="CommunityFeatures" class="form-control summernote">{{ $property->CommunityFeatures }}</textarea>
                <small class="form-text text-muted">Describe the community and its features</small>
            </div>
        </div>

        <!-- Agent Comments -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="PropertyFeatures">Agent Comments / Property Features</label>
                <textarea name="PropertyFeatures" id="PropertyFeatures" class="form-control summernote">{{ $property->PropertyFeatures }}</textarea>
                <small class="form-text text-muted">Internal notes and property features</small>
            </div>
        </div>

        <!-- Keywords -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="Keyword">Keywords</label>
                <textarea name="Keyword" id="Keyword" class="form-control summernote">{{ $property->Keyword }}</textarea>
                <small class="form-text text-muted">SEO keywords for property search</small>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Note:</strong> Amenities and Apartment Features checkboxes would go here. Since you didn't specify the exact amenities list, you can add them as checkboxes in this section. Example structure:
        <br><br>
        <strong>Amenities (Max 20):</strong> Pool, Gym, Parking, Laundry, etc.<br>
        <strong>Apartment Features:</strong> Balcony, Dishwasher, AC, Fireplace, etc.
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save General Details
        </button>
    </div>
</form>

@push('script')
<script>
    $('#generalDetailsForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.properties.update.general", $property->Id) }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    showError(errorMsg);
                } else {
                    showError('An error occurred while saving.');
                }
            }
        });
    });
</script>
@endpush
