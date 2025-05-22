<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <li class="active">
                    <a wire:navigate href="{{ route('dashboard') }}"> 
                        <i class="ti-dashboard"></i> Dashboard
                    </a>
                </li>

                <li class="label">Admin & Syatem Users</li>

                <li><a class="sidebar-sub-toggle"><i class="ti-lock"></i> Roles & Permissions<span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('role') }}">Roles</a></li>
                        <li><a wire:navigate href="{{ route('permissions') }}">Permissions</a></li>
                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> System Users<span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('users') }}">Users</a></li>
                        <li><a wire:navigate href="{{ route('activity-log') }}">Activity Log</a></li>
                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="ti-harddrives"></i> Master Data<span class="badge badge-primary">5</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('monthly-return.index') }}">Monthly Return</a></li>
                        <li><a wire:navigate href="{{ route('level-bonus.index') }}">Level Bonus</a></li>
                        <li><a wire:navigate href="{{ route('remuneration-benefit.index') }}">Remuneration</a></li>
                        {{-- <li><a href="javascript:void(0);">Award Master</a></li> --}}
                        {{-- <li><a href="javascript:void(0);">Franchise Benefit</a></li> --}}
                    </ul>
                </li>

                

                <li class="label">MLM Management</li>
                <li class="">
                    <a wire:navigate href="{{ route('settings.mlm-settings') }}"> 
                        <i class="ti-settings"></i> MLM Settings
                    </a>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-crown"></i>  Leaders  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('leaders.all')}}">All Leaders</a></li>
                        <li><a wire:navigate href="{{ route('binary.tree') }}">Tree View</a></li>
                        <li><a wire:navigate href="{{ route('binary.transfer') }}">Tranafer Tree</a></li>
                        <li><a wire:navigate href="{{ route('leaders.members-of-leader') }}">Members of Leader</a></li>
                    </ul>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-id-badge"></i>  KYC  <span class="badge badge-primary">4</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('kyc.pending') }}">Pending</a></li>
                        <li><a wire:navigate href="{{ route('kyc.cancelled') }}">Cancelled</a></li>
                        <li><a wire:navigate href="{{ route('kyc.completed') }}">Completed</a></li>
                        <li><a wire:navigate href="{{ route('kyc.all') }}">All KYC</a></li>
                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="ti-package"></i>  Orders & Products  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('orders.list') }}">Orders</a></li>
                        <li><a wire:navigate href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a wire:navigate href="{{ route('products.index') }}">Products</a></li>
                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="ti-stats-up"></i>  Reports  <span class="badge badge-primary">18</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="javascript:void(0);">ID Activation</a></li>
                        <li><a href="javascript:void(0);">Sales</a></li>
                        <li><a href="javascript:void(0);">TDS</a></li>
                        <li><a href="javascript:void(0);">Repurchase</a></li>
                        <li><a href="javascript:void(0);">Direct Bonus</a></li>
                        <li><a href="javascript:void(0);">Level Bonus</a></li>
                        <li><a href="javascript:void(0);">Investor Returns</a></li>
                        <li><a href="javascript:void(0);">Product Support</a></li>
                        <li><a href="javascript:void(0);">Payout</a></li>
                        <li><a href="javascript:void(0);">Payout History</a></li>
                        <li><a href="javascript:void(0);">Hold Amount</a></li>
                        <li><a href="javascript:void(0);">Paid/Unpaid Payments</a></li>
                        <li><a href="javascript:void(0);">Commission > 200</a></li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i>  Remuneration  <span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="javascript:void(0);">Transactions</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                            </ul>
                        </li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i>  Business  <span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="javascript:void(0);">Level-wise</a></li>
                                <li><a href="javascript:void(0);">Tree-wise</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);">Dilse Plan</a></li>
                        <li><a href="javascript:void(0);">Add-on</a></li>
                        <li><a href="javascript:void(0);">Product Delivery</a></li>
                    </ul>
                </li>

                <li class="label">Website Management</li>
                <li class="">
                    <a wire:navigate href="{{ route('settings.site-settings') }}"> 
                        <i class="ti-settings"></i> Site Settings
                    </a>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i>  Legal  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a wire:navigate href="{{ route('certificates.index') }}">Certificates</a></li>
                        <li><a wire:navigate href="{{ route('settings.terms') }}">Terms & Conditions</a></li>
                        <li><a wire:navigate href="{{ route('settings.privacy') }}">Privacy Policy</a></li>
                    </ul>
                </li>
                <li class="">
                    <a wire:navigate href="{{ route('ContactUsList.index') }}"> 
                        <i class="ti-email"></i> Contact Requests
                    </a>
                </li>
                <li class="">
                    <a wire:navigate href="{{ route('photo-galleries.index') }}"> 
                        <i class="ti-gallery"></i> Photo Gallery
                    </a>
                </li>

                
                {{-- <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-close"></i> Logout
                    </a>
                </li>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form> --}}
                
            </ul>
        </div>
    </div>
</div>