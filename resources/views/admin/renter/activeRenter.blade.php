@extends('admin.layouts.app')
@push('style')
<style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    
    /* Improved Button Styles */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }
    
    .btn-sm i {
        font-size: 0.875rem;
    }
    
    .btn-view {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border-color: #4e73df;
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #1cc88a, #0d8b5c);
        border-color: #1cc88a;
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #e74a3b, #be2617);
        border-color: #e74a3b;
        color: white;
    }
    
    .btn-view:hover {
        background: linear-gradient(45deg, #3a56c4, #1c3ca1);
        border-color: #3a56c4;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
    }
    
    .btn-edit:hover {
        background: linear-gradient(45deg, #17a673, #0a6e48);
        border-color: #17a673;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    }
    
    .btn-delete:hover {
        background: linear-gradient(45deg, #d52a1e, #9a1f15);
        border-color: #d52a1e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(231, 74, 59, 0.3);
    }
    
    .btn-view:active, .btn-edit:active, .btn-delete:active {
        transform: translateY(0);
    }
    
    /* Professional Pagination Styling */
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border: 1px solid #e3e6f0 !important;
        border-radius: 4px !important;
        color: #4e73df !important;
        background: white !important;
        transition: all 0.2s ease !important;
        font-size: 0.875rem;
        cursor: pointer !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(45deg, #4e73df, #224abe) !important;
        border-color: #4e73df !important;
        color: white !important;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.2);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(45deg, #f8f9fc, #e9ecef) !important;
        border-color: #4e73df !important;
        color: #224abe !important;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #858796 !important;
        background: #f8f9fc !important;
        border-color: #e3e6f0 !important;
        cursor: not-allowed !important;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        font-weight: 600;
    }
    
    /* Table and other existing styles remain the same */
    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .table th {
        background-color: #f8f9fc;
        font-weight: 600;
        color: #4e73df;
        border-bottom: 2px solid #e3e6f0;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .badge-success {
        background: linear-gradient(45deg, #1cc88a, #0d8b5c) !important;
    }
    
    .badge-danger {
        background: linear-gradient(45deg, #e74a3b, #be2617) !important;
    }
    
    #renters-table {
        width: 100% !important;
        margin-top: 10px;
    }
    
    #renters-table thead th {
        padding: 12px 15px;
        text-align: left;
        white-space: nowrap;
    }
    
    #renters-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Search and Length controls */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        outline: 0;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Status badges for probability */
    .badge-warning {
        background: linear-gradient(45deg, #f6c23e, #dda20a) !important;
    }
    
    .badge-info {
        background: linear-gradient(45deg, #36b9cc, #258391) !important;
    }
    
    /* Animation for buttons */
    .btn-sm {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush

@section('content')

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Active Renters</li>
            </ol>
            <h6 class="slim-pagetitle">Active Renters</h6>
        </div>
        
        <div class="section-wrapper">
            <div class="table-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Active Renters List</h5>
                    <div class="text-muted">
                        <span id="total-renters" class="badge badge-primary">0</span> Total Active Renters
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="renters-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email/Username</th>
                                <th>Probability</th>
                                <th>Status</th>
                                <th>Admin Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(function() {
        // Initialize DataTable with better configuration
        var table = $('#renters-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.renters.active.list') }}",
            order: [[0, 'desc']], // Sort by ID descending (latest first)
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                emptyTable: 'No active renters found',
                zeroRecords: 'No matching renters found',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Showing 0 to 0 of 0 entries',
                infoFiltered: '(filtered from _MAX_ total entries)',
                search: 'Search:',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            },
            columns: [
                {
                    data: 'Id',
                    name: 'Id',
                    width: '5%',
                    className: 'text-center'
                },
                {
                    data: 'Firstname',
                    name: 'renterinfo.Firstname',
                    render: function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'Lastname',
                    name: 'renterinfo.Lastname',
                    render: function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'UserName',
                    name: 'UserName',
                    render: function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'probability',
                    name: 'renterinfo.probability',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (!data) return '<span class="text-muted">-</span>';
                        
                        var color = 'success';
                        if (data < 30) color = 'danger';
                        else if (data < 60) color = 'warning';
                        else if (data < 80) color = 'info';
                        
                        return '<span class="badge badge-' + color + '">' + data + '%</span>';
                    }
                },
                {
                    data: 'status',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    data: 'adminname',
                    name: 'renterinfo.adminname',
                    render: function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '120px'
                }
            ],
            initComplete: function() {
                // Update total count
                $('#total-renters').text(this.api().data().length);
            },
            drawCallback: function() {
                // Update total count on each draw
                $('#total-renters').text(this.api().data().length);
                
                // Add tooltips to buttons
                $('.btn-view, .btn-edit, .btn-delete').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });
        
        // Delete button handler
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            
            if (confirm('Are you sure you want to delete this renter?')) {
                // Add loading state
                var $btn = $(this);
                $btn.html('<i class="fas fa-spinner fa-spin"></i>');
                $btn.prop('disabled', true);
                
                // Simulate delete request (replace with actual API call)
                setTimeout(function() {
                    table.row(row).remove().draw();
                    toastr.success('Renter deleted successfully');
                }, 1000);
            }
        });
        
        // Refresh button
        $('.btn-refresh').click(function() {
            table.ajax.reload();
        });
        
        // Search and length controls styling
        $('.dataTables_filter input').addClass('form-control form-control-sm');
        $('.dataTables_length select').addClass('form-control form-control-sm');
        
        // Add CSS classes to pagination buttons
        $(document).on('mouseenter', '.paginate_button:not(.disabled)', function() {
            $(this).addClass('hover');
        }).on('mouseleave', '.paginate_button', function() {
            $(this).removeClass('hover');
        });
    });
    
    // Button action functions
    function viewRenter(id) {
        alert('View renter with ID: ' + id);
        // window.location.href = '/admin/renters/' + id + '/view';
    }
    
    function editRenter(id) {
        alert('Edit renter with ID: ' + id);
        // window.location.href = '/admin/renters/' + id + '/edit';
    }
</script>
@endpush