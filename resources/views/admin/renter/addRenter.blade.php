@extends('admin.layouts.app')
@push('style')
<style>
    .show-password {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 14px;
        z-index: 10;
    }

    .form-group {
        margin-bottom: 1rem !important;
    }

    label.error {
        color: red;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    input.error,
    select.error,
    textarea.error {
        border-color: red !important;
        border: 1px solid red !important;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
        display: block !important;
    }

    input,
    select,
    textarea {
        transition: all 0.3s ease-in-out;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #d1d3e2 !important;
        height: 38px !important;
        border-radius: 0.25rem !important;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #4e73df !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .input-group {
        position: relative;
    }

    .input-group-prepend {
        z-index: 1;
    }

    /* Fix for Select2 dropdown visibility */
    .select2-container--open .select2-dropdown {
        z-index: 9999 !important;
    }

    .select2-results__options {
        max-height: 200px;
        overflow-y: auto;
    }

    .select2-results__option {
        padding: 6px 12px;
    }
</style>
@endpush
@section('content')
@php
$state = App\Models\State::all();
@endphp
<div class="slim-mainpanel">
    <div class="container">

        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Renters</li>
            </ol>
            <h6 class="slim-pagetitle">Add Renter</h6>
        </div>

        <div class="section-wrapper">
            <form id="rentersubmitform" action="{{ route('admin.store.renter') }}" method="POST" novalidate>
                @csrf
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="form-row">
                    <!-- Assign Agent -->
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="assignAgent" class="font-weight-bold">Assign Agent <span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('assignAgent') is-invalid @enderror" id="assignAgent" name="assignAgent" required>
                            <option value="">Select Agent</option>
                            @foreach ($agents as $row)
                            <option value="{{ $row->id }}" {{ old('assignAgent') == $row->id ? 'selected' : '' }}>{{ $row->admin_name }}</option>
                            @endforeach
                        </select>
                        @error('assignAgent')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="userName" class="font-weight-bold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('userName') is-invalid @enderror" id="userName" name="userName" value="{{ old('userName') }}" required>
                        @error('userName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="emailId" class="font-weight-bold">Email ID <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('emailId') is-invalid @enderror" id="emailId" name="emailId" value="{{ old('emailId') }}" required>
                        @error('emailId')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="password" class="font-weight-bold">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" required>
                            <span class="show-password" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Minimum 8 characters</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="password_confirmation" class="font-weight-bold">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            <span class="show-password" id="toggleConfirmationPassword">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Phone Numbers -->
                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="cell" class="font-weight-bold">Primary Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('cell') is-invalid @enderror" id="cell" name="cell" value="{{ old('cell') }}" required>
                        @error('cell')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="otherphone" class="font-weight-bold">Secondary Phone</label>
                        <input type="tel" class="form-control @error('otherphone') is-invalid @enderror" id="otherphone" name="otherphone" value="{{ old('otherphone') }}">
                        @error('otherphone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="firstName" class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" required>
                        @error('firstName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="lastName" class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" required>
                        @error('lastName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="form-group col-lg-2 col-md-6 col-12">
                        <label for="state" class="font-weight-bold">State <span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('state') is-invalid @enderror" data-placeholder="Choose State" name="state" id="state" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                            <option value="{{ $row->Id }}" {{ old('state') == $row->Id ? 'selected' : '' }}>
                                {{ $row->StateName }}
                            </option>
                            @endforeach
                        </select>
                        @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="form-group col-lg-2 col-md-6 col-12">
                        <label for="city" class="font-weight-bold">City <span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('city') is-invalid @enderror" id="city" name="city" required>
                            <option value="">Select City</option>
                        </select>
                        @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Zip Code -->
                    <div class="form-group col-lg-2 col-md-6 col-12">
                        <label for="zipCode" class="font-weight-bold">Zip Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('zipCode') is-invalid @enderror" id="zipCode" name="zipCode" value="{{ old('zipCode') }}" required>
                        @error('zipCode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Address -->
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="currentAddress" class="font-weight-bold">Moving From (Current Address) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('currentAddress') is-invalid @enderror" id="currentAddress" name="currentAddress" rows="3" required>{{ old('currentAddress') }}</textarea>
                        @error('currentAddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preferences -->
                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="floorpreference" class="font-weight-bold">Floor Preference</label>
                        <input type="text" class="form-control @error('floorpreference') is-invalid @enderror" id="floorpreference" name="floorpreference" value="{{ old('floorpreference') }}">
                        @error('floorpreference')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="garagePreference" class="font-weight-bold">Garage Preference</label>
                        <input type="text" class="form-control @error('garagePreference') is-invalid @enderror" id="garagePreference" name="garagePreference" value="{{ old('garagePreference') }}">
                        @error('garagePreference')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="laundryPreference" class="font-weight-bold">Laundry Preference</label>
                        <input type="text" class="form-control @error('laundryPreference') is-invalid @enderror" id="laundryPreference" name="laundryPreference" value="{{ old('laundryPreference') }}">
                        @error('laundryPreference')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="specificCrossStreet" class="font-weight-bold">Specific Cross Street</label>
                        <input type="text" class="form-control @error('specificCrossStreet') is-invalid @enderror" id="specificCrossStreet" name="specificCrossStreet" value="{{ old('specificCrossStreet') }}">
                        @error('specificCrossStreet')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- History -->
                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="communitiesVisited" class="font-weight-bold">Communities Visited</label>
                        <input type="text" class="form-control @error('communitiesVisited') is-invalid @enderror" id="communitiesVisited" name="communitiesVisited" value="{{ old('communitiesVisited') }}">
                        @error('communitiesVisited')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="creditHistory" class="font-weight-bold">Credit History</label>
                        <input type="text" class="form-control @error('creditHistory') is-invalid @enderror" id="creditHistory" name="creditHistory" value="{{ old('creditHistory') }}">
                        @error('creditHistory')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="rentalHistory" class="font-weight-bold">Rental History</label>
                        <input type="text" class="form-control @error('rentalHistory') is-invalid @enderror" id="rentalHistory" name="rentalHistory" value="{{ old('rentalHistory') }}">
                        @error('rentalHistory')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="criminalHistory" class="font-weight-bold">Criminal History</label>
                        <input type="text" class="form-control @error('criminalHistory') is-invalid @enderror" id="criminalHistory" name="criminalHistory" value="{{ old('criminalHistory') }}">
                        @error('criminalHistory')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Move Dates -->
                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="leaseTerm" class="font-weight-bold">Lease Term</label>
                        <input type="text" class="form-control @error('leaseTerm') is-invalid @enderror" id="leaseTerm" name="leaseTerm" value="{{ old('leaseTerm') }}">
                        @error('leaseTerm')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="earliestMoveDate" class="font-weight-bold">Earliest Move Date</label>
                        <input type="date" class="form-control @error('earliestMoveDate') is-invalid @enderror" id="earliestMoveDate" name="earliestMoveDate" value="{{ old('earliestMoveDate') }}">
                        @error('earliestMoveDate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="latestMoveDate" class="font-weight-bold">Latest Move Date</label>
                        <input type="date" class="form-control @error('latestMoveDate') is-invalid @enderror" id="latestMoveDate" name="latestMoveDate" value="{{ old('latestMoveDate') }}">
                        @error('latestMoveDate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="workNameAddress" class="font-weight-bold">Work Name/Address</label>
                        <input type="text" class="form-control @error('workNameAddress') is-invalid @enderror" id="workNameAddress" name="workNameAddress" value="{{ old('workNameAddress') }}">
                        @error('workNameAddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Move Area & Rent -->
                    <div class="form-group col-lg-4 col-md-6 col-12">
                        <label for="moveToArea" class="font-weight-bold">Desired Move Area</label>
                        <input type="text" class="form-control @error('moveToArea') is-invalid @enderror" id="moveToArea" name="moveToArea" value="{{ old('moveToArea') }}">
                        @error('moveToArea')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-4 col-md-6 col-12">
                        <label for="desiredRentRangeFrom" class="font-weight-bold">Rent Range From</label>
                        <input type="number" class="form-control @error('desiredRentRangeFrom') is-invalid @enderror" id="desiredRentRangeFrom" name="desiredRentRangeFrom" value="{{ old('desiredRentRangeFrom') }}">
                        @error('desiredRentRangeFrom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-4 col-md-6 col-12">
                        <label for="desiredRentRangeTo" class="font-weight-bold">Rent Range To</label>
                        <input type="number" class="form-control @error('desiredRentRangeTo') is-invalid @enderror" id="desiredRentRangeTo" name="desiredRentRangeTo" value="{{ old('desiredRentRangeTo') }}">
                        @error('desiredRentRangeTo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Source & Bedrooms -->
                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="source" class="font-weight-bold">Lead Source</label>
                        <select class="form-control @error('source') is-invalid @enderror" id="source" name="source">
                            <option value="">Select Source</option>
                            @foreach ($sources as $source)
                            <option value="{{ $source->Id }}" {{ old('source') == $source->Id ? 'selected' : '' }}>
                                {{ $source->SourceName }}
                            </option>
                            @endforeach
                        </select>
                        @error('source')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="bedroom" class="font-weight-bold">No. of Bedrooms</label>
                        <select class="form-control @error('bedroom') is-invalid @enderror" id="bedroom" name="bedroom">
                            <option value="">Select Bedroom</option>
                            @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('bedroom') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('bedroom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="petinfo" class="font-weight-bold">Pet Info</label>
                        <input type="text" class="form-control @error('petinfo') is-invalid @enderror" id="petinfo" name="petinfo" value="{{ old('petinfo') }}">
                        @error('petinfo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-12">
                        <label for="probability" class="font-weight-bold">Probability (%)</label>
                        <input type="number" class="form-control @error('probability') is-invalid @enderror" id="probability" name="probability" value="{{ old('probability') }}" min="0" max="100">
                        @error('probability')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Info -->
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="additionalinfo" class="font-weight-bold">Additional Info</label>
                        <textarea class="form-control @error('additionalinfo') is-invalid @enderror" id="additionalinfo" name="additionalinfo" rows="3">{{ old('additionalinfo') }}</textarea>
                        @error('additionalinfo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="locatorcomments" class="font-weight-bold">Locator Comments</label>
                        <textarea class="form-control @error('locatorcomments') is-invalid @enderror" id="locatorcomments" name="locatorcomments" rows="3">{{ old('locatorcomments') }}</textarea>
                        @error('locatorcomments')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="tourinfo" class="font-weight-bold">Tour Info</label>
                        <textarea class="form-control @error('tourinfo') is-invalid @enderror" id="tourinfo" name="tourinfo" rows="3">{{ old('tourinfo') }}</textarea>
                        @error('tourinfo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Reminder -->
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="setremainderdate" class="font-weight-bold">Set Reminder</label>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="date" class="form-control @error('setremainderdate') is-invalid @enderror" id="setremainderdate" name="setremainderdate" value="{{ old('setremainderdate') }}">
                                @error('setremainderdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="time" class="form-control @error('setremaindertime') is-invalid @enderror" id="setremaindertime" name="setremaindertime" value="{{ old('setremaindertime') }}">
                                @error('setremaindertime')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="remaindernote" class="font-weight-bold">Reminder Note</label>
                        <textarea class="form-control @error('remaindernote') is-invalid @enderror" id="remaindernote" name="remaindernote" rows="3">{{ old('remaindernote') }}</textarea>
                        @error('remaindernote')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="form-row justify-content-end">
                    <button type="submit" class="btn btn-primary submit-spinner">
                        <span class="btn-text">Add Renter</span>
                        <span class="spinner d-none">
                            <i class="fas fa-spinner fa-spin"></i> Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize Select2 with proper configuration
        $('.select2').each(function() {
            $(this).select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: $(this).data('placeholder') || 'Select an option',
                allowClear: true
            });
        });

        // Password toggle functionality
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const icon = $(this).find('i');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        $('#toggleConfirmationPassword').click(function() {
            const passwordField = $('#password_confirmation');
            const icon = $(this).find('i');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        // State-City AJAX - Fixed version
        $('#state').change(function() {
            const stateId = $(this).val();
            const citySelect = $('#city');
            
            // Clear and disable city dropdown
            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');
            citySelect.val('').trigger('change');
            
            if (!stateId) {
                citySelect.prop('disabled', true);
                return;
            }
            
            // Destroy current Select2 instance
            if (citySelect.hasClass('select2-hidden-accessible')) {
                citySelect.select2('destroy');
            }
            
            // Show loading
            citySelect.prop('disabled', true);
            citySelect.html('<option value="">Loading cities...</option>');
            
            $.ajax({
                url: '{{ route("admin.get.cities.by.state") }}',
                type: 'GET',
                data: { 
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Cities response:', response); // Debug log
                    
                    // Clear dropdown
                    citySelect.empty();
                    
                    if (response.cities && response.cities.length > 0) {
                        // Add placeholder
                        citySelect.append('<option value="">Select City</option>');
                        
                        // Add cities
                        $.each(response.cities, function(key, city) {
                            citySelect.append(new Option(city.CityName, city.Id, false, false));
                        });
                    } else {
                        citySelect.append('<option value="">No cities found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities:', error);
                    console.error('Response:', xhr.responseText);
                    citySelect.empty();
                    citySelect.append('<option value="">Error loading cities</option>');
                },
                complete: function() {
                    // Enable and reinitialize Select2
                    citySelect.prop('disabled', false);
                    
                    // Reinitialize Select2
                    citySelect.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: 'Select City',
                        allowClear: true
                    });
                    
                    // Select old value if exists
                    const oldCity = '{{ old("city") }}';
                    if (oldCity) {
                        setTimeout(function() {
                            citySelect.val(oldCity).trigger('change');
                        }, 300);
                    }
                }
            });
        });

        // Trigger state change if state has old value (with delay to ensure DOM is ready)
        @if(old('state'))
        setTimeout(function() {
            $('#state').val('{{ old("state") }}').trigger('change');
        }, 500);
        @endif

        // Form validation
        $('#rentersubmitform').validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorElement: "div",
            ignore: ":hidden:not(select)",
            rules: {
                assignAgent: {
                    required: true
                },
                userName: {
                    required: true,
                    minlength: 3
                },
                emailId: {
                    required: true,
                    email: true
                },
                firstName: {
                    required: true,
                    minlength: 2
                },
                lastName: {
                    required: true,
                    minlength: 2
                },
                cell: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                state: {
                    required: true
                },
                city: {
                    required: true
                },
                zipCode: {
                    required: true,
                    digits: true,
                    minlength: 5,
                    maxlength: 10
                },
                currentAddress: {
                    required: true,
                    minlength: 10
                },
                desiredRentRangeTo: {
                    greaterThan: "#desiredRentRangeFrom"
                },
                probability: {
                    min: 0,
                    max: 100
                }
            },
            messages: {
                assignAgent: {
                    required: "Please select an agent"
                },
                userName: {
                    required: "Please enter a username",
                    minlength: "Username must be at least 3 characters"
                },
                emailId: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                },
                firstName: {
                    required: "Please enter first name",
                    minlength: "First name must be at least 2 characters"
                },
                lastName: {
                    required: "Please enter last name",
                    minlength: "Last name must be at least 2 characters"
                },
                cell: {
                    required: "Please enter a phone number",
                    digits: "Please enter only digits",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number cannot exceed 15 digits"
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Password must be at least 8 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
                state: {
                    required: "Please select a state"
                },
                city: {
                    required: "Please select a city"
                },
                zipCode: {
                    required: "Please enter a zip code",
                    digits: "Please enter only numbers",
                    minlength: "Zip code must be at least 5 digits",
                    maxlength: "Zip code cannot exceed 10 digits"
                },
                currentAddress: {
                    required: "Please enter current address",
                    minlength: "Address must be at least 10 characters"
                },
                desiredRentRangeTo: {
                    greaterThan: "Rent range 'To' must be greater than 'From'"
                },
                probability: {
                    min: "Probability must be between 0 and 100",
                    max: "Probability must be between 0 and 100"
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            },
            submitHandler: function(form) {
                const submitBtn = $(form).find('.submit-spinner');
                const btnText = submitBtn.find('.btn-text');
                const spinner = submitBtn.find('.spinner');
                
                // Show spinner and disable button
                btnText.hide();
                spinner.removeClass('d-none');
                submitBtn.prop('disabled', true);
                
                // Allow form to submit normally
                return true;
            }
        });

        // Custom validation method for rent range
        $.validator.addMethod("greaterThan", function(value, element, param) {
            var fromValue = $(param).val();
            if (!value || !fromValue) return true;
            return parseFloat(value) > parseFloat(fromValue);
        }, "Rent range 'To' must be greater than 'From'");

        // Set minimum dates for date fields
        const today = new Date().toISOString().split('T')[0];
        $('#earliestMoveDate').attr('min', today);
        $('#latestMoveDate').attr('min', today);
        $('#setremainderdate').attr('min', today);

        // Real-time validation for move dates
        $('#earliestMoveDate, #latestMoveDate').on('change', function() {
            const earliest = $('#earliestMoveDate').val();
            const latest = $('#latestMoveDate').val();
            
            if (earliest && latest && earliest > latest) {
                alert('Latest move date must be after earliest move date');
                $(this).val('');
                $(this).valid();
            }
        });

        // Initialize form with old values for Select2
        @if(old('assignAgent'))
        setTimeout(function() {
            $('#assignAgent').val('{{ old("assignAgent") }}').trigger('change');
        }, 100);
        @endif

        @if(old('source'))
        setTimeout(function() {
            $('#source').val('{{ old("source") }}').trigger('change');
        }, 100);
        @endif

        @if(old('bedroom'))
        $('#bedroom').val('{{ old("bedroom") }}');
        @endif

        // Debug: Log when document is ready
        console.log('Document ready, Select2 initialized');
    });
</script>
@endpush