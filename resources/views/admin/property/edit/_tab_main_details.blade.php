<form id="mainDetailsForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- User Name -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="UserId">User Name</label>
                <select name="UserId" id="UserId" class="form-control">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->Id }}" {{ $property->UserId == $user->Id ? 'selected' : '' }}>
                            {{ $user->FullName ?? $user->Email ?? 'User #'.$user->Id }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Property Name -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="PropertyName" class="required">Property Name</label>
                <input type="text" name="PropertyName" id="PropertyName" class="form-control" 
                       value="{{ $property->PropertyName }}" required>
            </div>
        </div>

        <!-- Management Company -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Company">Management Company</label>
                <input type="text" name="Company" id="Company" class="form-control" 
                       value="{{ $property->Company }}">
            </div>
        </div>

        <!-- Number of Units -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Units">Number of Units</label>
                <input type="number" name="Units" id="Units" class="form-control" 
                       value="{{ $property->Units }}">
            </div>
        </div>

        <!-- Leasing Email -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Email">Leasing Email</label>
                <input type="email" name="Email" id="Email" class="form-control" 
                       value="{{ $property->Email }}">
            </div>
        </div>

        <!-- Year Built -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="Year">Year Built</label>
                <input type="number" name="Year" id="Year" class="form-control" 
                       value="{{ $property->Year }}" min="1900" max="{{ date('Y') }}">
            </div>
        </div>

        <!-- Year Remodeled -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="YearRemodel">Year Remodeled</label>
                <input type="number" name="YearRemodel" id="YearRemodel" class="form-control" 
                       value="{{ $property->YearRemodel }}" min="1900" max="{{ date('Y') }}">
            </div>
        </div>

        <!-- Fax -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Fax">Fax</label>
                <input type="text" name="Fax" id="Fax" class="form-control" 
                       value="{{ $property->Fax }}">
            </div>
        </div>

        <!-- Website -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="WebSite">Website</label>
                <input type="url" name="WebSite" id="WebSite" class="form-control" 
                       value="{{ $property->WebSite }}" placeholder="https://example.com">
            </div>
        </div>

        <!-- Address -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="Address">Address</label>
                <input type="text" name="Address" id="Address" class="form-control" 
                       value="{{ $property->Address }}">
            </div>
        </div>

        <!-- City -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="CityId">City</label>
                <select name="CityId" id="CityId" class="form-control">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->Id }}" {{ $property->CityId == $city->Id ? 'selected' : '' }}>
                            {{ $city->CityName }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Area -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="Area">Area</label>
                <input type="text" name="Area" id="Area" class="form-control" 
                       value="{{ $property->Area }}">
            </div>
        </div>

        <!-- Zip Code -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="Zip">Zip Code</label>
                <input type="text" name="Zip" id="Zip" class="form-control" 
                       value="{{ $property->Zip }}">
            </div>
        </div>

        <!-- Zone -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Zone">Zone</label>
                <input type="text" name="Zone" id="Zone" class="form-control" 
                       value="{{ $property->Zone }}">
            </div>
        </div>

        <!-- Contact No -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="ContactNo">Contact No</label>
                <input type="text" name="ContactNo" id="ContactNo" class="form-control" 
                       value="{{ $property->ContactNo }}">
            </div>
        </div>

        <!-- Latitude -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" 
                       value="{{ $property->latitude }}" step="any">
            </div>
        </div>

        <!-- Longitude -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" 
                       value="{{ $property->longitude }}" step="any">
            </div>
        </div>

        <!-- Office Hours -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="officehour">Office Hours</label>
                <textarea name="officehour" id="officehour" class="form-control" rows="3">{{ $property->officehour }}</textarea>
            </div>
        </div>

        <!-- Status Fields -->
        <div class="col-md-4">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Status" name="Status" 
                           value="1" {{ $property->Status == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="Status">Active</label>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Featured" name="Featured" 
                           value="1" {{ $property->Featured == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="Featured">Featured</label>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ActiveOnSearch" name="ActiveOnSearch" 
                           value="1" {{ $property->ActiveOnSearch == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="ActiveOnSearch">Active on Search</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Main Details
        </button>
    </div>
</form>

@push('script')
<script>
    $('#mainDetailsForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.properties.update", $property->Id) }}',
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
