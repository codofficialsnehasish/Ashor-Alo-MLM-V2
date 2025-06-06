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

                @canany(['View Role','View Permission'])
                <li><a class="sidebar-sub-toggle"><i class="ti-lock"></i> Roles & Permissions<span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View Role')
                        <li><a wire:navigate href="{{ route('role') }}">Roles</a></li>
                        @endcan
                        @can('View Permission')
                        <li><a wire:navigate href="{{ route('permissions') }}">Permissions</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['View User','Activity Log'])
                <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> System Users<span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View User')
                        <li><a wire:navigate href="{{ route('users') }}">Users</a></li>
                        @endcan
                        @can('Activity Log')
                        <li><a wire:navigate href="{{ route('activity-log') }}">Activity Log</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['View Monthly Return','View Level Bonus','View Remuneration Benefit'])
                <li><a class="sidebar-sub-toggle"><i class="ti-harddrives"></i> Master Data<span class="badge badge-primary">5</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View Monthly Return')
                        <li><a wire:navigate href="{{ route('monthly-return.index') }}">Monthly Return</a></li>
                        @endcan
                        @can('View Level Bonus')
                        <li><a wire:navigate href="{{ route('level-bonus.index') }}">Level Bonus</a></li>
                        @endcan
                        @can('View Remuneration Benefit')
                        <li><a wire:navigate href="{{ route('remuneration-benefit.index') }}">Remuneration</a></li>
                        @endcan
                        {{-- <li><a href="javascript:void(0);">Award Master</a></li> --}}
                        {{-- <li><a href="javascript:void(0);">Franchise Benefit</a></li> --}}
                    </ul>
                </li>
                @endcanany

                

                <li class="label">MLM Management</li>
                @can('Edit MLM Settings')
                <li class="">
                    <a wire:navigate href="{{ route('settings.mlm-settings') }}"> 
                        <i class="ti-settings"></i> MLM Settings
                    </a>
                </li>
                @endcan
                @canany(['View Leaders','Tree View','Transfer Tree','View Members Of Leader'])
                <li><a class="sidebar-sub-toggle"><i class="ti-crown"></i>  Leaders  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View Leaders')
                        <li><a wire:navigate href="{{ route('leaders.all')}}">All Leaders</a></li>
                        @endcan
                        @can('Tree View')
                        <li><a wire:navigate href="{{ route('binary.tree') }}">Tree View</a></li>
                        @endcan
                        @can('Transfer Tree')
                        <li><a wire:navigate href="{{ route('binary.transfer') }}">Tranafer Tree</a></li>
                        @endcan
                        @can('View Members Of Leader')
                        <li><a wire:navigate href="{{ route('leaders.members-of-leader') }}">Members of Leader</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['View KYC'])
                <li><a class="sidebar-sub-toggle"><i class="ti-id-badge"></i>  KYC  <span class="badge badge-primary">4</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View KYC')
                        <li><a wire:navigate href="{{ route('kyc.pending') }}">Pending</a></li>
                        @endcan
                        @can('View KYC')
                        <li><a wire:navigate href="{{ route('kyc.cancelled') }}">Cancelled</a></li>
                        @endcan
                        @can('View KYC')
                        <li><a wire:navigate href="{{ route('kyc.completed') }}">Completed</a></li>
                        @endcan
                        @can('View KYC')
                        <li><a wire:navigate href="{{ route('kyc.all') }}">All KYC</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['View Order','View Categories','View Products'])
                <li><a class="sidebar-sub-toggle"><i class="ti-package"></i>  Orders & Products  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View Order')
                        <li><a wire:navigate href="{{ route('orders.list') }}">Orders</a></li>
                        @endcan
                        @can('View Categories')
                        <li><a wire:navigate href="{{ route('categories.index') }}">Categories</a></li>
                        @endcan
                        @can('View Products')
                        <li><a wire:navigate href="{{ route('products.index') }}">Products</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany([
                    'ID Activation Report',
                    'Sales Report',
                    'TDS Report',
                    'Repurchase Report',
                    'Direct Bonus Report',
                    'Level Bonus Report',
                    'Investor Return Report',
                    'Product Support Report'
                    ])
                <li><a class="sidebar-sub-toggle"><i class="ti-stats-up"></i>  Reports  <span class="badge badge-primary">18</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('ID Activation Report')
                        <li><a wire:navigate href="{{ route('report.id-activation-report') }}">ID Activation</a></li>
                        @endcan
                        @can('Sales Report')
                        <li><a wire:navigate href="{{ route('report.sales-report') }}">Sales</a></li>
                        @endcan
                        @can('TDS Report')
                        <li><a wire:navigate href="{{ route('report.tds-report') }}">TDS</a></li>
                        @endcan
                        @can('Repurchase Report')
                        <li><a wire:navigate href="{{ route('report.repurchase-report') }}">Repurchase</a></li>
                        @endcan
                        @can('Direct Bonus Report')
                        <li><a wire:navigate href="{{ route('report.direct-bonus-report') }}">Direct Bonus</a></li>
                        @endcan
                        @can('Level Bonus Report')
                        <li><a wire:navigate href="{{ route('report.level-bonus-report') }}">Level Bonus</a></li>
                        @endcan
                        @can('Investor Return Report')
                        <li><a wire:navigate href="{{ route('report.investor-return-report') }}">Investor Returns</a></li>
                        @endcan
                        @can('Product Support Report')
                        <li><a wire:navigate href="{{ route('report.product-support-report') }}">Product Support</a></li>
                        @endcan
                        @canany(['Payout Report','Payout History Report','Hold Amount Report','Paid/Unpaid Payments Report','Commission < 200 Report'])
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> All Payout <span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                @can('Payout Report')
                                <li><a wire:navigate href="{{ route('report.payout-report') }}">Payout</a></li>
                                @endcan
                                @can('Payout History Report')
                                <li><a wire:navigate href="{{ route('report.payout-history-report') }}">Payout History</a></li>
                                @endcan
                                @can('Hold Amount Report')
                                <li><a wire:navigate href="{{ route('report.hold-amount-report') }}">Hold Amount</a></li>
                                @endcan
                                @can('Paid/Unpaid Payments Report')
                                <li><a wire:navigate href="{{ route('report.paid-unpaid-payment-report') }}">Paid/Unpaid Payments</a></li>
                                @endcan
                                @can('Commission < 200 Report')
                                <li><a wire:navigate href="{{ route('report.less-than-two-hundred-commission-report') }}">Commission < 200</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany
                        @canany(['Remuneration Transaction Report','Remuneration Report',])
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i>  Remuneration  <span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                @can('Remuneration Transaction Report')
                                <li><a wire:navigate href="{{ route('report.remuneration-transaction-report') }}">Transactions</a></li>
                                @endcan
                                @can('Remuneration Report')
                                <li><a wire:navigate href="{{ route('report.remuneration-report') }}">Reports</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany
                        @canany(['Level Wise Business Report','Tree Wise Business Report'])
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i>  Business  <span class="badge badge-primary">2</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                @can('Level Wise Business Report')
                                <li><a wire:navigate href="{{ route('report.level-wise-business-report') }}">Level-wise</a></li>
                                @endcan
                                @can('Tree Wise Business Report')
                                <li><a wire:navigate href="{{ route('report.tree-wise-business-report') }}">Tree-wise</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany
                        @can('View Products')
                        <li><a wire:navigate href="{{ route('report.dilse-plan-report') }}">Dilse Plan</a></li>
                        @endcan
                        @can('View Products')
                        <li><a wire:navigate href="{{ route('report.add-on-report') }}">Add-on</a></li>
                        @endcan
                        @can('View Products')
                        <li><a wire:navigate href="{{ route('report.product-delivery-report') }}">Product Delivery</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <li class="label">Website Management</li>
                @can('Edit Site Settings')
                <li class="">
                    <a wire:navigate href="{{ route('settings.site-settings') }}"> 
                        <i class="ti-settings"></i> Site Settings
                    </a>
                </li>
                @endcan
                @canany(['View Certificates','Edit Terms & Conditions','Edit Privacy Policy'])
                <li><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i>  Legal  <span class="badge badge-primary">3</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        @can('View Certificates')
                        <li><a wire:navigate href="{{ route('certificates.index') }}">Certificates</a></li>
                        @endcan
                        @can('Edit Terms & Conditions')
                        <li><a wire:navigate href="{{ route('settings.terms') }}">Terms & Conditions</a></li>
                        @endcan
                        @can('Edit Privacy Policy')
                        <li><a wire:navigate href="{{ route('settings.privacy') }}">Privacy Policy</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @can('View Contact Requests')
                <li class="">
                    <a wire:navigate href="{{ route('ContactUsList.index') }}"> 
                        <i class="ti-email"></i> Contact Requests
                    </a>
                </li>
                @endcan
                @can('Show Photo Gallery')
                <li class="">
                    <a wire:navigate href="{{ route('photo-galleries.index') }}"> 
                        <i class="ti-gallery"></i> Photo Gallery
                    </a>
                </li>
                @endcan
                @can('View Notice')
                <li class="">
                    <a wire:navigate href="{{ route('notice-board') }}"> 
                        <i class="ti-announcement"></i> Notice Board
                    </a>
                </li>
                @endcan
                
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