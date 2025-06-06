


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <title>Payment Receipt - {{ $order->order_number }}</title>
            <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        @media print {
            /* body {
                padding: 0;
            } */
            .no-print {
                display: none;
            }
        }
    </style>
    </head>
    <body class="">
        <style>
            body,span{
              font-family: "Roboto Condensed", sans-serif;
            }
        </style>
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Receipt
            </button>
            <button onclick="window.location.href='{{ route('orders.list') }}'" style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Back to Orders
            </button>
        </div>
        <div class="border-2 border-black h-auto w-full p-4 ">

            <!-- top portion -->
            <div class="flex justify-between">
                <div>
                    <img class="h-20" src="{{ optional(general_settings())->getFirstMediaUrl('site-logo') ?? '' }}" alt srcset>
                    <p>{{ optional(general_settings())->contact_address ?? '' }}</p>
                </div>

                <div class="my-auto border border-black px-4 py-2 ">
                    <h1 class="text-2xl" >PAYMENT RECEIPT</h1>
                </div>

                <div>
                    <p class="font-bold">{{ optional(general_settings())->site_name ?? '' }}</p>
                    {{-- <p>{{ optional(general_settings())->contact_address ?? '' }}</p> --}}
                    <p>Phone: {{ optional(general_settings())->contact_number ?? '' }}</p>
                </div>
            </div>

            <!-- Date -->
            <div class="flex justify-end mt-4">
                <h1>Date: <span class="font-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span></h1>
            </div>

            <!-- Form Text -->
             <div class="py-10">
                 <p class="text-2xl">
                     Received with thanks from
                     <span
                         class="font-bold">
                        &nbsp; {{ $order->user->name }}
                     </span>
                 </p>
     
                 <p class="text-2xl">
                     The sum amount of
                     <span
                         class="font-bold">
                         &nbsp; &#8377;{{ number_format($order->price_total, 2) }}/-
                     </span>
                 </p>
     
                 {{-- <p class="text-2xl">
                     For the purpose of
                     <span
                         class="font-bold">
                         &nbsp; Something
                     </span>
                 </p> --}}
                 <p class="text-2xl">By<span class="font-bold">&nbsp; {{ ucfirst($order->payment_method) }}</span></p>
             </div>


            <!-- Signature area -->
            <div class="flex justify-between w-full gap-10 mt-6 mb-6">
                <div class="w-1/4">
                    <hr class="h-0.5 w-full bg-black mb-1"></hr>
                    <p class="text-center">Received By</p>
                </div>

                <div class="w-1/4">
                    <hr class="h-0.5 w-full bg-black mb-1"></hr>
                    <p class="text-center">Authorizing Stamp/Signature</p>
                </div>
            </div>

        </div>
        <script>
            window.onload = function() {
                window.print();
            };
        </script>
    </body>
</html>