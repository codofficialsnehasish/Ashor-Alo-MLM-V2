<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">Ashor Alo</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);">
            <i class="fas fa-user-plus"></i>
            <span>Register Member</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#profilekyc"
            aria-expanded="true" aria-controls="profilekyc">
            <i class="fas fa-user-cog"></i>
            <span>Profile & KYC</span>
        </a>
        <div id="profilekyc" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Update Profile</a>
                <a class="collapse-item" href="javascript:void(0);">KYC Details</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseTeam"
            aria-expanded="true" aria-controls="collapseTeam">
            <i class="fas fa-users"></i>
            <span>My Team</span>
        </a>
        <div id="collapseTeam" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Direct</a>
                <a class="collapse-item" href="javascript:void(0);">Left Team</a>
                <a class="collapse-item" href="javascript:void(0);">Right Team</a>
                <a class="collapse-item" href="javascript:void(0);">All Team</a>
                <a class="collapse-item" href="javascript:void(0);">Tree View</a>
                <a class="collapse-item" href="javascript:void(0);">Level View</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#documents"
            aria-expanded="true" aria-controls="documents">
            <i class="fas fa-address-card"></i>
            <span>My Documents</span>
        </a>
        <div id="documents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Welcome Letter</a>
                <a class="collapse-item" href="javascript:void(0);">ID Card</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#payouts"
            aria-expanded="true" aria-controls="payouts">
            <i class="fas fa-wallet"></i>
            <span>Payouts</span>
        </a>
        <div id="payouts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Payouts</a>
                <a class="collapse-item" href="javascript:void(0);">Payout History</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#reports"
            aria-expanded="true" aria-controls="reports">
            <i class="fas fa-chart-line"></i>
            <span>Reports</span>
        </a>
        <div id="reports" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Topup Report</a>
                <a class="collapse-item" href="javascript:void(0);">Remuneration Report</a>
                <a class="collapse-item" href="javascript:void(0);">Dilse Plan Report</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#business-reports"
            aria-expanded="true" aria-controls="business-reports">
            <i class="fas fa-chart-line"></i>
            <span>Business Report</span>
        </a>
        <div id="business-reports" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="javascript:void(0);">Level Wise Report</a>
                <a class="collapse-item" href="javascript:void(0);">Tree Wise Report</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>