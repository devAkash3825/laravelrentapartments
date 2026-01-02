@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h5>Search Property</h5>

    <form method="GET" action="{{ route('admin.properties.index') }}">
        <div class="row">

            <div class="col-md-3">
                <label>Property Title</label>
                <input type="text" name="property_title" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Added By</label>
                <input type="text" name="added_by" class="form-control">
            </div>

            <div class="col-md-3">
                <label>From Date</label>
                <input type="text" name="date_from" class="form-control">
            </div>

            <div class="col-md-3">
                <label>To Date</label>
                <input type="text" name="date_to" class="form-control">
            </div>

            <div class="col-md-3 mt-2">
                <label>State</label>
                <select name="state_id" class="form-control">
                    <option value="">- SELECT STATE -</option>
                </select>
            </div>

            <div class="col-md-3 mt-2">
                <label>City</label>
                <select name="city_id" class="form-control">
                    <option value="">- SELECT CITY -</option>
                </select>
            </div>

            <div class="col-md-3 mt-2">
                <label>Zip Code</label>
                <input type="text" name="zip_code" class="form-control">
            </div>

            <div class="col-md-3 mt-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label>
                    <input type="checkbox" name="featured" value="1">
                    Featured Only
                </label>
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-primary">Search</button>
                <a href="{{ route('admin.properties.search') }}" class="btn btn-secondary">Reset</a>
            </div>

        </div>
    </form>
</div>
@endsection
