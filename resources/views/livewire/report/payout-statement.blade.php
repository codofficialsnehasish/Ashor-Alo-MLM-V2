<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                                <li><a wire:navigate href="{{ route('report.payout-report') }}">Payouts</a></li>
                                <li class="active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
 
                            <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    {{-- <a id="btn_print" type="button" value="print" class="btn btn-success mt-3 mb-3" onclick="">Print Statement</a> --}}
                                    <button 
                                        wire:ignore 
                                        onclick="printDiv('printableArea')" 
                                        class="btn btn-success mt-3 mb-3"
                                    >
                                        Print Statement
                                    </button>
                                </div>
                            </div>
                            <div id="printableArea" class="table-responsive" style="line-height:1.9;border: 6px solid #979696;padding:20px;border-radius: 15px;">
                                <center>
                                    <body>
                                        <table style="width: 800px;">
                                            <tbody>
                                                <tr>
                                                    <td align="center">
                                                        <img src="{{ optional(general_settings())->getFirstMediaUrl('site-logo') ?? '' }}" style="width: 100px;">
                                                        <h1 style="margin: 0;font-size: 20px;">ASHOR ALO </h1>
                                                        <h2 style="margin: 0;font-size: 16px;">{{ optional(general_settings())->contact_address ?? '' }}</h2>
                                                        <p style="margin: 0;font-size: 14px;"><b>E-Mail :</b> {{ optional(general_settings())->contact_email ?? '' }} </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table style="width: 800px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center">
                                                                        <h2 style="margin: 10px;font-size: 16px;">STATEMENT DATED ON {{ formated_date($payout->end_date,'-') }} </h2>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width: 800px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h2 style="margin: 0;font-size: 16px;margin-bottom: 5px;"><b>Name:</b> {{ get_name($payout->user_id) }}</h2>
                                                                        <h2 style="margin: 0;font-size: 16px;"> <b>ID:</b> {{ get_user_id($payout->user_id) }} </h2>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width: 800px;border: 1px solid #000;padding: 10px;margin-top: 20px;">
                                                            <tbody>
                                                                <tr style="text-align: left;">
                                                                    <th style="width: 630px;background: #cccccc59;padding: 10px;">Benifit Details</th>
                                                                    <th style="background: #cccccc59;padding: 10px;width: 170px;">Amount </th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;"> Direct Bonus</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->direct_bonus }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Level Bonus</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->lavel_bonus }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Remuneration Bonus</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->remuneration_bonus }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Product Return</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->roi }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Previous Hold Amount</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->hold_amount_added }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Previous Hold Wallet Amount</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->hold_wallet_added }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr></tr>
                                                <tr>
                                                    <td>
                                                        <table style="width: 800px;border: 1px solid #000;padding: 10px;">
                                                            <tbody>
                                                                <tr style="text-align: left;">
                                                                    <th style="width: 630px;background: #cccccc59;padding: 10px;">Gross incentive</th>
                                                                    <th style="background: #cccccc59;padding: 10px;">{{ $payout->direct_bonus + $payout->lavel_bonus + $payout->roi + $payout->hold_amount_added + $payout->remuneration_bonus + $payout->hold_wallet_added }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Less Repurchase Wallet {{ $payout->repurchase_persentage }}% </td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->direct_bonus_repurchase_deduction + $payout->lavel_bonus_repurchase_deduction + $payout->remuneration_bonus_repurchase_deduction }}</td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td style="width: 630px;padding: 10px;">Less <!--TDS --> Service charge {{ $payout->tds_persentage }}% </td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->direct_bonus_tds_deduction + $payout->lavel_bonus_tds_deduction + $payout->remuneration_bonus_tds_deduction }}</td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Less Service charge {{ $payout->tds_persentage }}% </td> {{-- $payout->service_charge_persentage --}}
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->direct_bonus_tds_deduction + $payout->lavel_bonus_tds_deduction + $payout->remuneration_bonus_tds_deduction + $payout->roi_tds_deduction }}</td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td style="width: 630px;padding: 10px;">Less Service charge {{ $payout->service_charge_persentage }}%</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->roi_tds_deduction }}</td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Hold Amount</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->hold_amount }}</td> 
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 630px;padding: 10px;">Hold Wallet Amount</td>
                                                                    <td style="padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->hold_wallet }}</td>
                                                                </tr>
                                                                <tr style="text-align: left;">
                                                                    <th style="width: 630px;background: #cccccc59;padding: 10px;">Previous Unpaid Amount</th>
                                                                    <th style="background: #cccccc59;padding: 10px;">{{ $payout->previous_unpaid_amount }}</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width: 800px;border: 1px solid #000;padding: 10px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-weight: bold;width: 630px;">Net Payable Amount</td>
                                                                    <td style="font-weight: bold;padding: 10px;width: 170px;border-left: 1px solid #ccc;">{{ $payout->total_payout }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <h2 style="margin: 10px;font-size: 16px;">The amount will be credited to your bank account within seven days</h2>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </body>
                                </center>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>