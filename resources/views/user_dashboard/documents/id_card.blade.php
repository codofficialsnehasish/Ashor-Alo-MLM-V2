
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://ashoralo.in/public/site_data_images/https://ashoralo.in/public/site_data_images/1711967547cutlog.png">

    <title>ID Card | Ashor Alo</title>

    <!-- Custom fonts for this template-->
    <link href="https://ashoralo.in/public/site_assets/user_dashboard_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://ashoralo.in/public/site_assets/user_dashboard_assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="https://ashoralo.in/public/site_assets/user_dashboard_assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Toast message -->
    <link href="https://ashoralo.in/public/dashboard_assets/libs/toast/toastr.css" rel="stylesheet" type="text/css" />
    <!-- Toast message -->

    <!-- Sweet Alert-->
   <link href="https://ashoralo.in/public/dashboard_assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="https://ashoralo.in/public/dashboard_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://ashoralo.in/public/dashboard_assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
    <!-- Responsive datatable examples -->
    <link href="https://ashoralo.in/public/dashboard_assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

    <link href="https://ashoralo.in/public/dashboard_assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
    .id-card-holder {
		width: 225px;
		padding: 4px;
		margin: 0 auto;
		/* background-color: #1f1f1f; */
		border-radius: 5px;
		position: relative;
		box-shadow: 0px 0px 5px 0px #00000047;
        margin: 5px;
        height: 414px;
	}

	.id-card {	
		background-color: #fff;
		padding: 10px;
		border-radius: 10px;
		text-align: center;
		/* box-shadow: 0 0 1.5px 0px #b9b9b9; */
	}
	.id-card img {
		margin: 0 auto;
	}
	.header img {
		width: 75px;
		margin-top: 15px;
	}
	.photo img {
		width: 120px;
		margin-top: 15px;
		height: 120px;
		border-radius: 100%;
		border: 2px solid #71cf2c;
		margin-bottom: 20px;
	}
	h2 {
		font-size: 14px;
		margin: 5px 0;
		color: black;
	}
	h3 {
		font-size: 12px;
		margin: 2.5px 0;
		font-weight: 300;
		color: black;
	}
	.qr-code img {
		width: 50px;
	}
	p {
		font-size: 5px;
		margin: 2px;
	}

	.id-card-tag{
		width: 0;
		height: 0;
		border-left: 100px solid transparent;
		border-right: 100px solid transparent;
		border-top: 100px solid #d9300f;
		margin: -10px auto -30px auto;
	}

	.id-card-tag:after {
		content: '';
		display: block;
		width: 0;
		height: 0;
		border-left: 50px solid transparent;
		border-right: 50px solid transparent;
		border-top: 100px solid white;
		margin: -10px auto -30px auto;
		position: relative;
		top: -130px;
		left: -50px;
	}

    .id-card h4 {
        font-size: 12px;
        color: black;
    }

    h3.id-back-address {
        padding: 69px 0;
    }
</style>
</head>

<body id="page-top">    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ID Card</h6>
                        </div>
                        <div class="card-body">
                        <a id="btn_print" type="button" value="print" class="btn btn-success mt-3 mb-3" onclick="">Print ID Card</a>
                            <div id="printableArea" class="table-responsive">
                                <div class="d-flex align-items-center justify-content-center text-center" id="PrintMe">
                                    
                                    <div class="id-card-holder">
                                        <div class="id-card">
                                            <div class="header">
                                                <img src="https://ashoralo.in/public/site_data_images/1711967812cutlog.png">
                                            </div>
                                            <div class="photo">
                                                <img src="{{ $user->getFirstMediaUrl('profile-image') && $user->hasMedia('profile-image') 
                                                        ? $user->getFirstMediaUrl('profile-image') 
                                                        : asset('dashboard_assets/images/users/user-13.jpg') }}">
                                            </div>
                                            <h2>{{ $user->name }}</h2>
                                            <!-- <div class="qr-code">
                                                
                                            </div> -->
                                            <h3>ID : {{ $user->member_number }}</h3>
                                            <h3>Mobile : {{ $user->phone }}</h3>
                                            <h3>Address: {{ $user->address?->address ?? '' }}</h3>
                                            <hr>
                                            <p><strong>Ashor Alo</strong><p>
                                            <p>Thacker House, 35, Chittaranjan Avenue, 4th Floor, Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal</p>
                                        </div>
                                    </div>
                                    <div class="id-card-holder">
                                        <div class="id-card">
                                            <div class="header">
                                                <img src="https://ashoralo.in/public/site_data_images/1711967812cutlog.png">
                                            </div>
                                            <!-- <div class="qr-code">
                                                
                                            </div> -->
                                            <h3 class="id-back-address">Thacker House, 35, Chittaranjan Avenue, 4th Floor, Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal</h3>
                                            <img src="https://codeofdolphins.com/backup/hospital/assets/images/cards/d89ec4041dc4180be6fdc3ba625b5994.png" alt="">
                                            <hr>
                                            <h4>Authorized Signature</h4>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <script src="https://ashoralo.in/public/site_assets/user_dashboard_assets/vendor/jquery/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#btn_print').click(function() {
                        var printContents = $('#printableArea').html();
                        var originalContents = $('body').html();

                        $('body').html(printContents);
                        window.print();
                        $('body').html(originalContents);
                    });
                });
            </script>