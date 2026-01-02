@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h5>Property Listing</h5>

    <table class="table table-bordered" id="properties-table">
        <thead>
            <tr>
                <th>Property</th>
                <th>City</th>
                <th>State</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('script')
<script>
    $('#properties-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.properties.datatable') }}",
            data: {
                property_title: "{{ request('property_title') }}",
                added_by: "{{ request('added_by') }}",
                date_from: "{{ request('date_from') }}",
                date_to: "{{ request('date_to') }}",
                state_id: "{{ request('state_id') }}",
                city_id: "{{ request('city_id') }}",
                zip_code: "{{ request('zip_code') }}",
                status: "{{ request('status') }}",
                featured: "{{ request('featured') }}"
            }
        },
        columns: [{
                data: 'PropertyName'
            },
            {
                data: 'city'
            },
            {
                data: 'state'
            },
            {
                data: 'price'
            },
            {
                data: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
</script>
@endpush