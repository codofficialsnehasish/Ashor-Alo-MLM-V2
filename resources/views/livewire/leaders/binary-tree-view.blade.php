<style>
    .n-ppost-name{
        top: 0;
        left: 66%;
        margin-top: 10px;
        width: 460px;
        opacity: 0;
        -webkit-transform: translate3d(0, -15px, 0);
        transform: translate3d(0, -15px, 0);
        -webkit-transition: all 150ms linear;
        -o-transition: all 150ms linear;
        transition: all 150ms linear;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.4;
        visibility: hidden;
        pointer-events: none;
        position: absolute;
        background: #79cf3ed1;
        color: #000;
        padding: 10px;
        z-index: 999999999999;
    }

    .n-ppost:hover + .n-ppost-name {
        opacity: 1;
        visibility: visible;
        -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
    }

    .left {
        float: left;
        width: 50%;
    }

    .left .element {
        float: left;
        width: 100%;
        text-align: left;
    }

    .right {
        float: left;
        width: 50%;
    }
    .right .element {
        float: left;
        width: 100%;
        text-align: left;
    }
    .left .element label {
        float: left;
        width: 43%;
    }
    .right .element label {
        float: left;
        width: 43%;
    }

    .n-ppost-name .element {
        text-align: left;
    }
    /*----------------genealogy-scroll----------*/

    .genealogy-scroll::-webkit-scrollbar {
        width: 5px;
        height: 8px;
    }
    .genealogy-scroll::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: #e4e4e4;
    }
    .genealogy-scroll::-webkit-scrollbar-thumb {
        background: #212121;
        border-radius: 10px;
        transition: 0.5s;
    }
    .genealogy-scroll::-webkit-scrollbar-thumb:hover {
        background: #d5b14c;
        transition: 0.5s;
    }


    /*----------------genealogy-tree----------*/
    .genealogy-body{
        white-space: nowrap;
        overflow-y: visible;
        padding: 50px;
        min-height: 500px;
        padding-top: 10px;
        text-align: center;
    }
    .genealogy-tree{
        display: inline-block;
    }
    .genealogy-tree ul {
        padding-top: 20px; 
        position: relative;
        padding-left: 0px;
        display: flex;
        justify-content: center;
    }
    .genealogy-tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;
    }
    .genealogy-tree li::before, .genealogy-tree li::after{
        content: '';
        position: absolute; 
        top: 0; 
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%; 
        height: 18px;
    }
    .genealogy-tree li::after{
        right: auto; left: 50%;
        border-left: 2px solid #ccc;
    }
    .genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
        display: none;
    }
    .genealogy-tree li:only-child{ 
        padding-top: 0;
    }
    .genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
        border: 0 none;
    }
    .genealogy-tree li:last-child::before{
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .genealogy-tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }
    .genealogy-tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 2px solid #ccc;
        width: 0; height: 20px;
    }
    .genealogy-tree li a{
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
    }

    .genealogy-tree li a:hover, 
    .genealogy-tree li a:hover+ul li a {
        background: #c8e4f8;
        color: #000;
    }

    .genealogy-tree li a:hover+ul li::after, 
    .genealogy-tree li a:hover+ul li::before, 
    .genealogy-tree li a:hover+ul::before, 
    .genealogy-tree li a:hover+ul ul::before{
        border-color:  #fbba00;
    }

    /*--------------memeber-card-design----------*/

    .member-view-box{
        /* padding-bottom: 10px; */
        text-align: center;
        /* border-radius: 4px; */
        position: relative;
        /* border: 1px; */
        /* border-color: #e4e4e4; */
        /* border-style: solid; */
    }
    .member-image{
        padding:10px;
        width: 100%;
        position: relative;
    }
    .member-image img{
        width: 100px;
        height: 100px;
        border-radius: 6px;
        background-color :#fff;
        z-index: 1;
    }
    .member-header-active {
        padding: 5px 0;
        text-align: center;
        background: #02a499;
        color: #fff;
        font-size: 14px;
        border-radius: 4px 4px 0 0;
    }
    .member-header-inactive {
        padding: 5px 0;
        text-align: center;
        background: #ec4561;
        color: #fff;
        font-size: 14px;
        border-radius: 4px 4px 0 0;
    }
    .member-footer {
        text-align: center;
    }
    .member-footer div.name {
        color: #000;
        /* font-size: 14px; */
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .member-footer div.downline {
        color: #000;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-overlay .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Home</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                {{-- @if ($root)
                    <div class="tree d-flex justify-content-center">
                        @include('components.tree-node', ['node' => $root])
                    </div>
                @else
                    <div class="alert alert-warning">No root node found.</div>
                @endif --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive" style="/*display:flex;justify-content:center;*/">       
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Search Form -->
                                    <div>
                                        <form action="https://ashoralo.in/admin/reports/tree-wise" method="get" class="d-flex" id="search-form">
                                            <input type="search" id="search-query" class="form-control form-control-sm me-2" placeholder="Search by name or ID" name="query" aria-controls="datatable-buttons" minlength="3" autocomplete="off">
                                        </form>
                                        
                                        <!-- Suggestions Dropdown -->
                                        <div id="suggestions" class="list-group position-absolute" style="display: none; z-index: 999;"></div>
                                        
                                    </div>
                
                                    <!-- Back Button -->
                                    <div>
                                        <button onclick="history.back()" class="btn btn-outline-success">
                                            <img src="https://ashoralo.in/public/dashboard_assets/images/back.png" width="36px" height="26px" alt=""> Back
                                        </button>
                                    </div>
                                
                                </div>
                                {{-- <div class="body genealogy-body genealogy-scroll">
                                    <div class="genealogy-tree">
                                        <ul id="tree-container">
                                            <li>
                                                <a href="https://ashoralo.in/admin/customer/tree-view/65343685" onmouseover="MemberDetails(65343685)">
                                                    <div class="member-view-box n-ppost">
                                                        <div class="member-header">
                                                            <span></span>
                                                        </div>
                                                        <div class="member-image">
                                                            <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-14.png" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid green;" alt="Member" class="rounded-circle">
                                                        </div>
                                                        <div class="member-footer">
                                                            <div class="name"><span>ASHOR ALO</span></div>
                                                            <div class="downline"><span>(65343685)</span></div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul class="active">
                                                    <li>
                                                        <a href="https://ashoralo.in/admin/customer/tree-view/14859933" onmouseover="MemberDetails(14859933)">
                                                            <div class="member-view-box n-ppost">
                                                                <div class="member-header">
                                                                    <span></span>
                                                                </div>
                                                                <div class="member-image">
                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-14.png" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid green;" alt="Member" class="rounded-circle">
                                                                </div>
                                                                <div class="member-footer">
                                                                    <div class="name"><span>ASHOR ALO</span></div>
                                                                    <div class="downline"><span>(14859933)</span></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="https://ashoralo.in/admin/customer/tree-view/65818377" onmouseover="MemberDetails(65818377)">
                                                                    <div class="member-view-box n-ppost">
                                                                        <div class="member-header">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="member-image">
                                                                            <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-14.png" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid green;" alt="Member" class="rounded-circle">
                                                                        </div>
                                                                        <div class="member-footer">
                                                                            <div class="name"><span>ASHOR ALO</span></div>
                                                                            <div class="downline"><span>(65818377)</span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="https://ashoralo.in/admin/customer/tree-view/51858248" onmouseover="MemberDetails(51858248)">
                                                                            <div class="member-view-box n-ppost">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-14.png" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid green;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span>ASHOR ALO</span></div>
                                                                                    <div class="downline"><span>(51858248)</span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box">
                                                                        <div class="member-header">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="member-image">
                                                                            <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                        </div>
                                                                        <div class="member-footer">
                                                                            <div class="name"><span> </span></div>
                                                                            <div class="downline"><span> </span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box">
                                                                <div class="member-header">
                                                                    <span></span>
                                                                </div>
                                                                <div class="member-image">
                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                </div>
                                                                <div class="member-footer">
                                                                    <div class="name"><span> </span></div>
                                                                    <div class="downline"><span> </span></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box">
                                                                        <div class="member-header">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="member-image">
                                                                            <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                        </div>
                                                                        <div class="member-footer">
                                                                            <div class="name"><span> </span></div>
                                                                            <div class="downline"><span> </span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box">
                                                                        <div class="member-header">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="member-image">
                                                                            <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                        </div>
                                                                        <div class="member-footer">
                                                                            <div class="name"><span> </span></div>
                                                                            <div class="downline"><span> </span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box">
                                                                                <div class="member-header">
                                                                                    <span></span>
                                                                                </div>
                                                                                <div class="member-image">
                                                                                    <img src="https://ashoralo.in/public/dashboard_assets/images/users/user-16.png" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" alt="Member" class="rounded-circle">
                                                                                </div>
                                                                                <div class="member-footer">
                                                                                    <div class="name"><span> </span></div>
                                                                                    <div class="downline"><span> </span></div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div> --}}
                                <div class="body genealogy-body genealogy-scroll">
                                    <!-- Loading overlay - shows during Livewire updates -->
                                    <div wire:loading class="loading-overlay">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading tree...</span>
                                        </div>
                                    </div>
                                    @if($root)
                                        <div class="d-flex justify-content-between mb-3">
                                            @if($currentRootId)
                                                <button wire:click="loadTree()" class="btn btn-sm btn-primary">
                                                    Back to Root
                                                </button>
                                            @else
                                                <div></div> <!-- Empty spacer -->
                                            @endif
                                        </div>
                                
                                        <div class="genealogy-tree">
                                            <ul id="tree-container">
                                                {{-- <x-tree-node  --}}
                                                <livewire:leaders.tree-partials.tree-node
                                                    :node="$root" 
                                                    :currentDepth="1" 
                                                    :maxDepth="$levelsToShow"
                                                    wire:key="node-{{ $root->user_id }}"
                                                />
                                            </ul>
                                        </div>
                                    @else
                                        <p class="text-center">No tree data found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleNodeClick(userId) {
        console.log(userId);
        Livewire.dispatch('loadTree', userId);
    }
</script>