<form id="additionalDetailsForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Leasing Terms -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="LeasingTerms">Leasing Terms</label>
                <textarea name="LeasingTerms" id="LeasingTerms" class="form-control summernote">{{ $property->additionalInfo->LeasingTerms ?? '' }}</textarea>
            </div>
        </div>

        <!-- Qualifying Criteria -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="QualifiyingCriteria">Qualifying Criteria</label>
                <textarea name="QualifiyingCriteria" id="QualifiyingCriteria" class="form-control summernote">{{ $property->additionalInfo->QualifiyingCriteria ?? '' }}</textarea>
            </div>
        </div>

        <!-- Parking -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="Parking">Parking</label>
                <textarea name="Parking" id="Parking" class="form-control summernote">{{ $property->additionalInfo->Parking ?? '' }}</textarea>
            </div>
        </div>

        <!-- Pet Policy -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="PetPolicy">Pet Policy</label>
                <textarea name="PetPolicy" id="PetPolicy" class="form-control summernote">{{ $property->additionalInfo->PetPolicy ?? '' }}</textarea>
            </div>
        </div>

        <!-- Neighborhood -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="Neighborhood">Neighborhood</label>
                <textarea name="Neighborhood" id="Neighborhood" class="form-control summernote">{{ $property->additionalInfo->Neighborhood ?? '' }}</textarea>
            </div>
        </div>

        <!-- Driving Directions -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="drivedirection">Driving Directions</label>
                <textarea name="drivedirection" id="drivedirection" class="form-control summernote">{{ $property->additionalInfo->drivedirection ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Additional Details
        </button>
    </div>
</form>

@push('script')
<script>
    $('#additionalDetailsForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.properties.update.additional", $property->Id) }}',
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
