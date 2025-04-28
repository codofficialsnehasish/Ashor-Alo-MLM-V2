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
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-bag f-s-22 color-primary border-primary round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>$1278</h4>
                                    <h6>Earning</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-bar-chart f-s-22 color-warning border-warning round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>37%</h4>
                                    <h6>Conversion</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-comment f-s-22 color-success border-success round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>68748</h4>
                                    <h6>Visitors</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-location-pin f-s-22 border-danger color-danger round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>$689</h4>
                                    <h6>Today Sale</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header m-b-37">
                                <h4>Recent Orders </h4>
                                <div class="card-header-right-icon">
                                    <ul>
                                        <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                        <li class="card-option drop-menu"><i class="ti-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="link"></i>
                                            <ul class="card-option-dropdown dropdown-menu">
                                                <li><a href="#"><i class="ti-loop"></i> Update data</a></li>
                                                <li><a href="#"><i class="ti-menu-alt"></i> Detail log</a></li>
                                                <li><a href="#"><i class="ti-pulse"></i> Statistics</a></li>
                                                <li><a href="#"><i class="ti-power-off"></i> Clear ist</a></li>
                                            </ul>
                                        </li>
                                        <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Manage</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="round-img">
                                                    <a href=""><img src="assets/images/avatar/1.jpg" alt=""></a>
                                                </div>
                                            </td>
                                            <td>Lew Shawon</td>
                                            <td><span class="badge badge-primary">Samsang Pro</span></td>
                                            <td class="color-primary">$21.56</td>
                                            <td>
                                                <span><a href=""><i class="ti-pencil-alt color-success m-r-5"></i></a></span>
                                                <span><a href=""><i class="ti-trash color-danger m-l-5"></i> </a></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="round-img">
                                                    <a href=""><img src="assets/images/avatar/1.jpg" alt=""></a>
                                                </div>
                                            </td>
                                            <td>Lew Shawon</td>
                                            <td><span class="badge badge-primary">Nokia-456</span></td>
                                            <td class="color-success">$55.32</td>
                                            <td>
                                                <span><a href=""><i class="ti-pencil-alt color-success m-r-5"></i></a></span>
                                                <span><a href=""><i class="ti-trash color-danger m-l-5"></i> </a></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="round-img">
                                                    <a href=""><img src="assets/images/avatar/1.jpg" alt=""></a>
                                                </div>
                                            </td>
                                            <td>Lew Shawon</td>
                                            <td><span class="badge badge-primary">Ipone-7</span></td>
                                            <td class="color-danger">$14.85</td>
                                            <td>
                                                <span><a href=""><i class="ti-pencil-alt color-success m-r-5"></i></a></span>
                                                <span><a href=""><i class="ti-trash color-danger m-l-5"></i> </a></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="round-img">
                                                    <a href=""><img src="assets/images/avatar/1.jpg" alt=""></a>
                                                </div>
                                            </td>
                                            <td>lew Shawon</td>
                                            <td><span class="badge badge-primary">Ipone-7</span></td>
                                            <td class="color-danger">$14.85</td>
                                            <td>
                                                <span><a href=""><i class="ti-pencil-alt color-success m-r-5"></i></a></span>
                                                <span><a href=""><i class="ti-trash color-danger m-l-5"></i> </a></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="round-img">
                                                    <a href=""><img src="assets/images/avatar/1.jpg" alt=""></a>
                                                </div>
                                            </td>
                                            <td>lew Shawon</td>
                                            <td><span class="badge badge-primary">Ipone-7</span></td>
                                            <td class="color-danger">$14.85</td>
                                            <td>
                                                <span><a href=""><i class="ti-pencil-alt color-success m-r-5"></i></a></span>
                                                <span><a href=""><i class="ti-trash color-danger m-l-5"></i> </a></span>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>This dashboard was generated on <span id="date-time"></span> <a href="#" class="page-refresh">Refresh Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>