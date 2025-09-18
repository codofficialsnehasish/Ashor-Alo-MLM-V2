<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ID Card | Ashor Alo</title>
    <style>
        @page { margin: 10px; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }

        .id-card-holder {
            width: 225px;
            height: 414px;
            padding: 4px;
            margin: 5px;
            border-radius: 5px;
            position: relative;
            box-shadow: 0px 0px 5px 0px #00000047;
            display: inline-block;
            vertical-align: top;
        }
        .id-card {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            height: 100%;
        }
        .header img {
            width: 75px;
            margin-top: 15px;
        }
        .photo img {
            width: 120px;
            height: 120px;
            margin-top: 15px;
            margin-bottom: 20px;
            border-radius: 100%;
            border: 2px solid #71cf2c;
        }
        h2 {
            font-size: 14px;
            margin: 5px 0;
            color: black;
        }
        h3 {
            font-size: 12px;
            margin: 2px 0;
            font-weight: normal;
            color: black;
        }
        .qr-code img {
            width: 50px;
        }
        p {
            font-size: 10px;
            margin: 2px;
        }
        .id-card h4 {
            font-size: 12px;
            color: black;
        }
        .id-back-address {
            padding: 40px 0;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">

        <!-- FRONT SIDE -->
        <div class="id-card-holder">
            <div class="id-card">
                <div class="header">
                    <img src="{{ asset('assets/logo-color.png') }}" alt="Logo">
                </div>
                <div class="photo">
                    <img src="{{ $user->getFirstMediaUrl('profile-image') && $user->hasMedia('profile-image') 
                        ? $user->getFirstMediaUrl('profile-image') 
                        : asset('assets/images/treeUsers/user-13.jpg') }}" alt="Profile" width="100">
                </div>
                <h2>{{ $user->name }}</h2>
                <h3>ID : {{ $user->member_number }}</h3>
                <h3>Mobile : {{ $user->phone }}</h3>
                <h3>Address: {{ $user->address?->address ?? '' }}</h3>
                <hr>
                <p><strong>Ashor Alo</strong></p>
                <p>Thacker House, 35, Chittaranjan Avenue, 4th Floor,<br>
                   Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal</p>
            </div>
        </div>

        <!-- BACK SIDE -->
        <div class="id-card-holder">
            <div class="id-card">
                <div class="header">
                    <img src="{{ asset('assets/logo-color.png') }}" alt="Logo">
                </div>
                <h3 class="id-back-address">
                    Thacker House, 35, Chittaranjan Avenue, 4th Floor,<br>
                    Kolkata 700012, Near 5 No Gate Chandni Metro,<br>
                    West Bengal
                </h3>
                <img src="https://codeofdolphins.com/backup/hospital/assets/images/cards/d89ec4041dc4180be6fdc3ba625b5994.png" alt="QR/Barcode" style="width:100px; margin:20px 0;">
                <hr>
                <h4>Authorized Signature</h4>
            </div>
        </div>

    </div>
</body>
</html>
