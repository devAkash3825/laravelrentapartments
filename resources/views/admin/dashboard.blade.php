@extends('admin.layouts.app')
@section('content')
@section('title', 'RentEase Admin | Dashboard')

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --success-color: #4cc9f0;
        --warning-color: #f72585;
        --info-color: #7209b7;
        --dark-color: #2b2d42;
        --light-color: #f8f9fa;
        --border-radius: 16px;
        --box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(30deg);
    }

    .welcome-text {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtext {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 600px;
    }

    .date-display {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        text-align: center;
        min-width: 200px;
    }

    /* Widget Cards */
    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-content {
        margin-top: 0.5rem;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-change {
        display: inline-flex;
        align-items: center;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .stat-change.positive {
        background: rgba(76, 201, 240, 0.15);
        color: var(--success-color);
    }

    .stat-change.negative {
        background: rgba(247, 37, 133, 0.15);
        color: var(--warning-color);
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
    }

    .card-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 1.5rem 1.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--primary-color);
    }

    /* Table Styling */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead th {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table tbody td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: var(--transition);
    }

    .data-table tbody tr:hover td {
        background: #f8fafc;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        font-size: 0.875rem;
    }

    .avatar-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-info h6 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--dark-color);
    }

    .user-info small {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    .badge-success {
        background: rgba(76, 201, 240, 0.15);
        color: var(--success-color);
    }

    .badge-success::before {
        background: var(--success-color);
    }

    .badge-warning {
        background: rgba(247, 37, 133, 0.15);
        color: var(--warning-color);
    }

    .badge-warning::before {
        background: var(--warning-color);
    }

    .badge-info {
        background: rgba(114, 9, 183, 0.15);
        color: var(--info-color);
    }

    .badge-info::before {
        background: var(--info-color);
    }

    .badge-secondary {
        background: rgba(43, 45, 66, 0.15);
        color: var(--dark-color);
    }

    .badge-secondary::before {
        background: var(--dark-color);
    }

    /* Action Buttons */
    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
    }

    /* Quick Stats */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: var(--transition);
    }

    .stat-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .stat-item-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.25rem;
    }

    .stat-item-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Activity Feed */
    .activity-feed {
        padding: 1.5rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-weight: 500;
        color: var(--dark-color);
        margin-bottom: 0.25rem;
    }

    .activity-time {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: #94a3b8;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .welcome-text {
            font-size: 1.75rem;
        }

        .date-display {
            width: 100%;
        }
    }
</style>

<div class="slim-mainpanel">
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="d-flex flex-column">
                <h1 class="welcome-text">Welcome back, <span class="text-warning">Admin</span>! 👋</h1>
                <p class="welcome-subtext">
                    Here's an overview of your property management platform. You have
                    <strong>24 pending applications</strong> and
                    <strong>8 maintenance requests</strong> to review.
                </p>
            </div>
            <div class="date-display mt-3 mt-md-0">
                <div class="tx-uppercase tx-11 opacity-75">Today's Date</div>
                <h5 class="mb-0">{{ \Carbon\Carbon::today()->format('l, F d, Y') }}</h5>
            </div>
        </div>

        <!-- Renter Statistics -->
        <div class="row mg-b-30">
            <div class="col-lg-12">
                <h4 class="section-title mb-4 d-flex align-items-center">
                    <i class="icon ion-ios-people-outline mg-r-10"></i>
                    Renter Analytics
                    <span class="badge bg-light text-dark ms-3">Last 30 Days</span>
                </h4>
            </div>

            <!-- Total Renters -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="icon ion-ios-people"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">1,856</div>
                        <div class="stat-label">Total Renters</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            12.5% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Renters -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="icon ion-ios-checkmark-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">1,402</div>
                        <div class="stat-label">Active Renters</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            8.2% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leased Renters -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="icon ion-ios-home"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">956</div>
                        <div class="stat-label">Leased Renters</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            15.7% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inactive Renters -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="icon ion-ios-close-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">154</div>
                        <div class="stat-label">Inactive Renters</div>
                        <div class="stat-change negative">
                            <i class="icon ion-arrow-down-c mg-r-5"></i>
                            3.1% decrease
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Statistics -->
        <div class="row mg-b-30">
            <div class="col-lg-12">
                <h4 class="section-title mb-4 d-flex align-items-center">
                    <i class="icon ion-ios-home-outline mg-r-10"></i>
                    Property Analytics
                    <span class="badge bg-light text-dark ms-3">This Quarter</span>
                </h4>
            </div>

            <!-- Total Properties -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #2b2d42, #4a4e69);">
                        <i class="icon ion-ios-list"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">412</div>
                        <div class="stat-label">Total Properties</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            7.3% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Properties -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #38b000, #2d7d46);">
                        <i class="icon ion-ios-checkmark-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">389</div>
                        <div class="stat-label">Active Properties</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            5.8% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vacant Properties -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ff9e00, #ff9100);">
                        <i class="icon ion-ios-alert"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">23</div>
                        <div class="stat-label">Vacant Properties</div>
                        <div class="stat-change negative">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            3.4% increase
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="col-sm-6 col-lg-3 mg-b-20">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #06d6a0, #05c793);">
                        <i class="icon ion-ios-cash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">$124.8K</div>
                        <div class="stat-label">Monthly Revenue</div>
                        <div class="stat-change positive">
                            <i class="icon ion-arrow-up-c mg-r-5"></i>
                            18.2% increase
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Renters & Properties -->
        <div class="row mg-b-30">
            <!-- Recent Renters -->
            <div class="col-lg-6 mg-b-30 mg-lg-b-0">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="icon ion-ios-time"></i>
                            Recent Renters
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Renter</th>
                                    <th>Status</th>
                                    <th>Property</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="user-avatar" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                                                JS
                                            </div>
                                            <div class="user-info">
                                                <h6>John Smith</h6>
                                                <small>john.smith@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-success">Active</span>
                                    </td>
                                    <td>
                                        <small>Luxury Apartments • 5B</small>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="user-avatar" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                                                MJ
                                            </div>
                                            <div class="user-info">
                                                <h6>Maria Johnson</h6>
                                                <small>maria.j@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-info">Leased</span>
                                    </td>
                                    <td>
                                        <small>City View Condos • 12A</small>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="user-avatar" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                                                RB
                                            </div>
                                            <div class="user-info">
                                                <h6>Robert Brown</h6>
                                                <small>rbrown@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-warning">Pending</span>
                                    </td>
                                    <td>
                                        <small>Garden Villas • 8C</small>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="user-avatar" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                                                SD
                                            </div>
                                            <div class="user-info">
                                                <h6>Sarah Davis</h6>
                                                <small>sarah.d@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-secondary">Inactive</span>
                                    </td>
                                    <td>
                                        <small>Riverfront Lofts • Studio</small>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Properties -->
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="icon ion-ios-home"></i>
                            Recent Properties
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 style="font-weight: 600; margin-bottom: 0.25rem;">Luxury Apartments</h6>
                                            <small class="text-muted">Downtown • 3B2B</small>
                                        </div>
                                    </td>
                                    <td>Apartment</td>
                                    <td>
                                        <strong>$2,850</strong>
                                        <small class="d-block text-muted">/month</small>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">Manage</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 style="font-weight: 600; margin-bottom: 0.25rem;">City View Condos</h6>
                                            <small class="text-muted">Financial District • 2B2B</small>
                                        </div>
                                    </td>
                                    <td>Condo</td>
                                    <td>
                                        <strong>$3,200</strong>
                                        <small class="d-block text-muted">/month</small>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-info">Leased</span>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">Manage</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 style="font-weight: 600; margin-bottom: 0.25rem;">Garden Villas</h6>
                                            <small class="text-muted">Suburban • 4B3B</small>
                                        </div>
                                    </td>
                                    <td>Villa</td>
                                    <td>
                                        <strong>$4,500</strong>
                                        <small class="d-block text-muted">/month</small>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-secondary">Inactive</span>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">Manage</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 style="font-weight: 600; margin-bottom: 0.25rem;">Riverfront Lofts</h6>
                                            <small class="text-muted">River North • Studio</small>
                                        </div>
                                    </td>
                                    <td>Studio</td>
                                    <td>
                                        <strong>$1,850</strong>
                                        <small class="d-block text-muted">/month</small>
                                    </td>
                                    <td>
                                        <span class="status-badge badge-warning">Pending</span>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-view">Manage</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats & Activity -->
        <div class="row mg-b-40">
            <!-- Quick Stats -->
            <div class="col-lg-4 mg-b-30 mg-lg-b-0">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="icon ion-ios-stats"></i>
                            Quick Stats
                        </h5>
                    </div>
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-item-value">98.2%</div>
                            <div class="stat-item-label">Occupancy Rate</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-value">24</div>
                            <div class="stat-item-label">Pending Apps</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-value">12</div>
                            <div class="stat-item-label">Maintenance</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-value">48</div>
                            <div class="stat-item-label">New Leads</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="icon ion-ios-notifications"></i>
                            Recent Activity
                        </h5>
                    </div>
                    <div class="activity-feed">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon ion-ios-person-add"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    <strong>John Smith</strong> submitted a rental application for Luxury Apartments
                                </div>
                                <div class="activity-time">10 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon ion-ios-checkmark-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Property <strong>City View Condos</strong> status changed to Leased
                                </div>
                                <div class="activity-time">45 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon ion-ios-add-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    New property <strong>Riverfront Lofts</strong> was added to the platform
                                </div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon ion-ios-build"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Maintenance request completed for <strong>Unit 5B</strong>
                                </div>
                                <div class="activity-time">Yesterday, 4:30 PM</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon ion-ios-document"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Monthly financial report has been generated
                                </div>
                                <div class="activity-time">Yesterday, 11:00 AM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('adminscripts')
<script>
    // Dashboard animations
    $(document).ready(function() {
        // Animate stat cards on load
        gsap.from('.stat-card', {
            duration: 0.8,
            y: 30,
            opacity: 0,
            stagger: 0.1,
            ease: "power3.out"
        });

        // Animate tables on load
        gsap.from('.data-table tbody tr', {
            duration: 0.6,
            x: -20,
            opacity: 0,
            stagger: 0.05,
            ease: "power2.out",
            delay: 0.3
        });

        // Add hover effects
        $('.stat-card').hover(
            function() {
                gsap.to($(this), {
                    duration: 0.3,
                    y: -5,
                    boxShadow: '0 20px 60px rgba(0, 0, 0, 0.12)',
                    ease: "power2.out"
                });
            },
            function() {
                gsap.to($(this), {
                    duration: 0.3,
                    y: 0,
                    boxShadow: '0 10px 40px rgba(0, 0, 0, 0.08)',
                    ease: "power2.out"
                });
            }
        );

        // Update time dynamically
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit'
            });
            $('.time-display').text(timeString);
        }

        // Update every minute
        setInterval(updateTime, 60000);
        updateTime();

        // Button click effects
        $('.action-btn').on('click', function() {
            gsap.to($(this), {
                duration: 0.2,
                scale: 0.95,
                yoyo: true,
                repeat: 1,
                ease: "power2.inOut"
            });
        });

        // Add loading animation
        function simulateLoading() {
            $('.stat-value').each(function() {
                const $this = $(this);
                const finalValue = $this.text();
                $this.text('0');

                gsap.to($this, {
                    duration: 1.5,
                    innerText: finalValue,
                    snap: {
                        innerText: 1
                    },
                    ease: "power2.out",
                    delay: Math.random() * 0.5
                });
            });
        }

        // Run loading animation on page load
        setTimeout(simulateLoading, 500);
    });
</script>

<!-- Include GSAP for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

@endpush