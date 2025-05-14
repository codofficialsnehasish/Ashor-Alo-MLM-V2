
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- App favicon -->
    <link rel="shortcut icon" href="">

    <title>Welcome Letter | Ashor Alo</title>

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
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f4f7;
        color: #333;
    }
    .container {
        width: 80%;
        max-width: 600px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #007bff;
        margin-top: 0;
    }
    p {
        line-height: 1.6;
    }
    .footer {
        margin-top: 20px;
        font-size: 0.9em;
        color: #666;
    }
    .footer a {
        color: #007bff;
        text-decoration: none;
    }
</style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Welcome Letter</h6>
                        </div>
                        <div class="card-body">
                            <a id="btn_print" type="button" value="print" class="btn btn-success mt-3 mb-3" onclick="">Print Letter</a>
                            <div id="printableArea" class="table-responsive" style="line-height:1.9;border: 6px solid #979696;padding:20px;border-radius: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="https://ashoralo.in/public/site_data_images/1711967812cutlog.png" height="190px" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <div style="padding: 5px;text-align:right;">
                                            <span style="font-size: 22px;color: blue;font-weight: bold;"><span>Ashor Alo</span></span>
                                            <br>
                                            <span style="font-weight: bold;"><span>Thacker House, 35, Chittaranjan Avenue, 4th Floor, Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal</span></span>
                                            <br>
                                            <!-- <span style="font-weight: bold;">Phone No &nbsp;:&nbsp;</span><span>03348106029</span>
                                            <span>, Mobile No &nbsp;:&nbsp; </span>
                                            <span>7439763048</span>
                                            <br> -->
                                            <span style="font-weight: bold;">Email ID &nbsp;:&nbsp; </span><a href="#"><span>ashoralo.in@gmail.com</span></a><br>
                                            <span style="font-weight: bold;">Website &nbsp;:&nbsp; </span><a href="#"><span>https://ashoralo.in/</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-3 mb-3">
                                    <h1 class="text-center">Welcome Letter</h1>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Aheartly Welcome To {{ $user->name }}</b>
                                        <p>Dear,Mr./Miss/Mrs./Ms : {{ $user->name }},</p>
                                        <p>ID : {{ $user->member_number }},</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="padding: 5px;text-align:right;">
                                            <b>DATE : {{ formated_date($user->created_at) }}</b>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" style="padding:14px;">
                                    <p>It is great pleasure welcome you to Ashor Alo</p>
                                    <p>We sincerely believe that you’re joining to this company as an “INDIVIDUAL DISTRIBUTOR” helps and supports the company to reach the sky high goals in no time. We also appreciate your decision and spontaneous action implementing attitude which has always been found to the great people of the world. You have wisely and rightly chosen this company which speaks itself about wittiness and understanding and your trust and confidence in companies policies plans & products, management capability and off course company’s prospective growth. “If you grow definitely the company will and that’s the motto of the company. And the more completely give of yourself, the more completely the company will give back to you”.</p>
                                    <p>We as company promise you that your Belo vent services will surely be looked forward to a step ahead. We are determine that your life package in terms of mental,physical,social and financial must be preserved as a priceless diamond and that will be our good will for you. Last but not least, we once again welcome you and take you as our one of the best prospective “DISTRIBUTOR” with wide open sky opportunities. “With Best Wishes fly high with us as a family member” Thanks and regards.</p>
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