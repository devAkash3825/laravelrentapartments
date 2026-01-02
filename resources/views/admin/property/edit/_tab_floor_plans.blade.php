<div class="mb-3">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addFloorPlanModal">
        <i class="fas fa-plus"></i> Add New Floor Plan
    </button>
</div>

<!-- Floor Plans Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="floorPlansTable">
        <thead>
            <tr>
                <th>Category</th>
                <th>Plan Name</th>
                <th>Plan Type</th>
                <th>Footage</th>
                <th>Price</th>
                <th>Deposit</th>
                <th>Available</th>
                <th>Special</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($property->floorPlans as $floorPlan)
            <tr data-id="{{ $floorPlan->Id }}">
                <td>{{ $floorPlan->category->Name ?? 'N/A' }}</td>
                <td>{{ $floorPlan->PlanName }}</td>
                <td>{{ $floorPlan->PlanType }}</td>
                <td>{{ $floorPlan->Footage ? number_format($floorPlan->Footage) . ' sq ft' : 'N/A' }}</td>
                <td>{{ $floorPlan->Price ? '$' . number_format($floorPlan->Price) : 'N/A' }}</td>
                <td>{{ $floorPlan->deposit ?? 'N/A' }}</td>
                <td>
                    @if($floorPlan->isavailable == 1)
                        <span class="badge badge-success">Yes</span>
                    @else
                        <span class="badge badge-secondary">No</span>
                    @endif
                </td>
                <td>{{ $floorPlan->special ? Str::limit($floorPlan->special, 30) : '-' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info edit-floorplan" 
                            data-id="{{ $floorPlan->Id }}"
                            data-category="{{ $floorPlan->CategoryId }}"
                            data-planname="{{ $floorPlan->PlanName }}"
                            data-plantype="{{ $floorPlan->PlanType }}"
                            data-footage="{{ $floorPlan->Footage }}"
                            data-price="{{ $floorPlan->Price }}"
                            data-deposit="{{ $floorPlan->deposit }}"
                            data-comments="{{ $floorPlan->Comments }}"
                            data-special="{{ $floorPlan->special }}"
                            data-expiry="{{ $floorPlan->expiry_date }}"
                            data-availdate="{{ $floorPlan->avail_date }}"
                            data-isavailable="{{ $floorPlan->isavailable }}"
                            data-availurl="{{ $floorPlan->Available_Url }}"
                            data-floorplanlink="{{ $floorPlan->floorplan_link }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger delete-floorplan" data-id="{{ $floorPlan->Id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No floor plans found. Click "Add New Floor Plan" to create one.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add/Edit Floor Plan Modal -->
<div class="modal fade" id="addFloorPlanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="floorPlanModalTitle">Add Floor Plan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="floorPlanForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="floorPlanId" name="floorPlanId">
                <input type="hidden" id="formMethod" value="POST">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CategoryId" class="required">Category</label>
                                <select name="CategoryId" id="CategoryId" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($floorPlanCategories as $category)
                                        <option value="{{ $category->Id }}">{{ $category->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="PlanName">Plan Name</label>
                                <input type="text" name="PlanName" id="PlanName" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="PlanType">Plan Type</label>
                                <input type="text" name="PlanType" id="PlanType" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Footage">Square Footage</label>
                                <input type="number" name="Footage" id="Footage" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Price">Price (Monthly Rent)</label>
                                <input type="number" name="Price" id="Price" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deposit">Deposit</label>
                                <input type="text" name="deposit" id="deposit" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Comments">Comments</label>
                                <textarea name="Comments" id="Comments" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="special">Special Offers</label>
                                <textarea name="special" id="special" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry_date">Special Expiry Date</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avail_date">Available Date</label>
                                <input type="date" name="avail_date" id="avail_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Available_Url">Availability URL</label>
                                <input type="url" name="Available_Url" id="Available_Url" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="floorplan_link">Floor Plan Link</label>
                                <input type="url" name="floorplan_link" id="floorplan_link" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="FloorPlan">Floor Plan Image</label>
                                <input type="file" name="FloorPlan" id="FloorPlan" class="form-control-file" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mt-4">
                                    <input type="checkbox" class="custom-control-input" id="isavailable" name="isavailable" value="1">
                                    <label class="custom-control-label" for="isavailable">Available for Rent</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Floor Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    // Add Floor Plan
    $('#floorPlanForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let floorPlanId = $('#floorPlanId').val();
        let method = floorPlanId ? 'PUT' : 'POST';
        let url = floorPlanId 
            ? '{{ route("admin.properties.floorplans.update", [$property->Id, ":id"]) }}'.replace(':id', floorPlanId)
            : '{{ route("admin.properties.floorplans.store", $property->Id) }}';
        
        if(method === 'PUT') {
            formData.append('_method', 'PUT');
        }
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    $('#addFloorPlanModal').modal('hide');
                    location.reload(); // Reload to show updated data
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    showError(errorMsg);
                } else {
                    showError('An error occurred while saving floor plan.');
                }
            }
        });
    });

    // Edit Floor Plan - Populate Modal
    $(document).on('click', '.edit-floorplan', function() {
        let $btn = $(this);
        $('#floorPlanModalTitle').text('Edit Floor Plan');
        $('#floorPlanId').val($btn.data('id'));
        $('#formMethod').val('PUT');
        $('#CategoryId').val($btn.data('category'));
        $('#PlanName').val($btn.data('planname'));
        $('#PlanType').val($btn.data('plantype'));
        $('#Footage').val($btn.data('footage'));
        $('#Price').val($btn.data('price'));
        $('#deposit').val($btn.data('deposit'));
        $('#Comments').val($btn.data('comments'));
        $('#special').val($btn.data('special'));
        $('#expiry_date').val($btn.data('expiry'));
        $('#avail_date').val($btn.data('availdate'));
        $('#Available_Url').val($btn.data('availurl'));
        $('#floorplan_link').val($btn.data('floorplanlink'));
        $('#isavailable').prop('checked', $btn.data('isavailable') == 1);
        
        $('#addFloorPlanModal').modal('show');
    });

    // Reset form when adding new
    $('#addFloorPlanModal').on('hidden.bs.modal', function() {
        $('#floorPlanForm')[0].reset();
        $('#floorPlanId').val('');
        $('#formMethod').val('POST');
        $('#floorPlanModalTitle').text('Add Floor Plan');
    });

    // Delete Floor Plan
    $(document).on('click', '.delete-floorplan', function() {
        if(!confirm('Are you sure you want to delete this floor plan?')) return;
        
        let floorPlanId = $(this).data('id');
        let url = '{{ route("admin.properties.floorplans.delete", [$property->Id, ":id"]) }}'.replace(':id', floorPlanId);
        
        $.ajax({
            url: url,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    showSuccess(response.message);
                    $('tr[data-id="' + floorPlanId + '"]').remove();
                }
            },
            error: function(xhr) {
                showError('An error occurred while deleting floor plan.');
            }
        });
    });
</script>
@endpush
