<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome Letter | Ashor Alo</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; color: #333;">

    <div style="width: 100%; padding: 0; margin: 0;">

        <!-- Header -->
        <table width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <img src="{{ public_path('assets/logo-color.png') }}" alt="Logo" style="height:100px;">
                </td>
                <td style="width: 75%; text-align: right; vertical-align: top;">
                    <span style="font-size: 22px; color: blue; font-weight: bold;">Ashor Alo</span><br>
                    <span style="font-weight: bold; display: block;">
                        Thacker House, 35, Chittaranjan Avenue, 4th Floor, <br/> Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal
                    </span><br>
                    <span style="font-weight: bold;">Email ID:&nbsp;</span>
                    <a href="mailto:ashoralo.in@gmail.com" style="color: #007bff; text-decoration: none;">ashoralo.in@gmail.com</a><br>
                    <span style="font-weight: bold;">Website:&nbsp;</span>
                    <a href="https://ashoralo.in/" style="color: #007bff; text-decoration: none;">https://ashoralo.in/</a>
                </td>
            </tr>
        </table>


        <!-- Title -->
        <div style="text-align: center; margin: 20px 0;">
            <h1 style="color: #007bff; margin: 0; font-size: 28px;">Welcome Letter</h1>
        </div>

        <!-- User Info -->
        <table width="100%" style="border-collapse: collapse; margin: 10px 0;">
            <tr>
                <!-- Left Side -->
                <td style="width: 80%; text-align: left; vertical-align: top; padding: 5px;">
                    <b style="display: block; margin-bottom: 8px;">A heartly Welcome To {{ $user->name }}</b>
                    <p style="margin: 0; line-height: 1.6;">Dear Mr./Miss/Mrs./Ms : {{ $user->name }},</p>
                    <p style="margin: 0; line-height: 1.6;">ID : {{ $user->member_number }}</p>
                </td>
        
                <!-- Right Side -->
                <td style="width: 20%; text-align: right; vertical-align: top; padding: 5px;">
                    <b style="font-size: 14px;">DATE : {{ formated_date($user->created_at) }}</b>
                </td>
            </tr>
        </table>


        <!-- Letter Body -->
        <div style="padding: 14px; line-height: 1.6; font-size: 14px; text-align: justify;">
            <p style="margin: 0 0 12px 0;">It is great pleasure welcome you to Ashor Alo</p>
            <p style="margin: 0 0 12px 0;">We sincerely believe that you’re joining to this company as an “INDIVIDUAL DISTRIBUTOR” helps and supports the company to reach the sky high goals in no time. We also appreciate your decision and spontaneous action implementing attitude which has always been found to the great people of the world. You have wisely and rightly chosen this company which speaks itself about wittiness and understanding and your trust and confidence in companies policies plans & products, management capability and off course company’s prospective growth. “If you grow definitely the company will and that’s the motto of the company. And the more completely give of yourself, the more completely the company will give back to you”.</p>
            <p style="margin: 0 0 12px 0;">We as company promise you that your Belo vent services will surely be looked forward to a step ahead. We are determine that your life package in terms of mental,physical,social and financial must be preserved as a priceless diamond and that will be our good will for you. Last but not least, we once again welcome you and take you as our one of the best prospective “DISTRIBUTOR” with wide open sky opportunities. “With Best Wishes fly high with us as a family member” Thanks and regards.</p>
        </div>

    </div>
</body>
</html>
