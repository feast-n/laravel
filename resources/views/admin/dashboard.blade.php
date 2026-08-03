@extends('layouts.admin_template')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard</h1>
        @if(session('role') === 'admin' || session('role') === 'manager')
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
        @endif
    </div>

@if(session('role') === 'admin')
    <div class="row mb-4">
        <!-- Student Management -->
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('student') }}" class="text-decoration-none">
                <div class="card text-white text-center bg-primary pt-3 shadow h-100">
                    <i class="fas fa-user-graduate fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Student Management</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Contact Management -->
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('contact.index') }}" class="text-decoration-none">
                <div class="card text-white text-center bg-primary pt-3 shadow h-100">
                    <i class="fas fa-address-book fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Contact Management</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Blog Management -->
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('blog.index') }}" class="text-decoration-none">
                <div class="card text-white text-center bg-primary pt-3 shadow h-100">
                    <i class="fas fa-blog fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Blog Management</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- User Management -->
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('usermg.index') }}" class="text-decoration-none">
                <div class="card text-white text-center bg-primary pt-3 shadow h-100">
                    <i class="fas fa-users fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif

    <!-- Content Row - Cards Summary -->
    <div class="row">
        @if(session('role') === 'admin')
        <!-- Earnings (Monthly) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tasks Progress Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Charts / Details -->
    <div class="row">
        <!-- Projects Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects Progress</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"></div>
                    </div>
                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                    </div>
                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%"></div>
                    </div>
                    @if(session('role') === 'admin')
                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"></div>
                    </div>
                    @endif
                    <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Overview -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Approach</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang di Panel Admin, <strong>{{ session('name') ?? 'User' }}</strong>.</p>
                    @if(session('role') === 'admin')
                        <p>Anda memiliki akses penuh untuk mengelola data student, melihat ringkasan performa sistem, serta mengatur alur kerja aplikasi secara langsung melalui navbar di atas.</p>
                    @else
                        <p>Anda memiliki akses terbatas untuk melihat ringkasan tugas dan status permintaan sistem.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
