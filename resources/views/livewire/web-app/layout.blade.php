<!doctype html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Ashor Alo</title>
      <meta name="robots" content="noindex, follow" />
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('web-assets/images/icon-img/fav.png') }}">
      <!-- All CSS is here ============================================ -->
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ asset('web-assets/css/vendor/bootstrap.min.css') }}">
      <!-- Icon Font CSS -->
      <link rel="stylesheet" href="{{ asset('web-assets/css/vendor/font-awesome.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/vendor/dlicon.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/vendor/font-la-icon-outline.min.css') }}">
      <!-- Others CSS -->
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/owl-carousel.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/magnific-popup.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/jquery-ui.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/jarallax.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/slick.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/easyzoom.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/plugins/animate.css') }}">
      <!-- Main Style CSS -->
      <link rel="stylesheet" href="{{ asset('web-assets/css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('web-assets/css/responsive.css') }}">

      <style>
         #expandableContainer:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
         }
         
         /* Initial state - no border when collapsed */
         #expandableContainer {
            border: none !important;
         }
         
         /* Add border when expanded */
         #expandableContainer[style*="white"] {
            border: 1px solid #dee2e6 !important;
         }
      </style>
   </head>
   <body>
      <div class="main-wrapper main-wrapper-2 main-wrapper-3">
         @livewire('web-app.header')
         {{ $slot }}
         @livewire('web-app.footer')
         <!-- Modal -->
      </div>
      <!-- All JS is here ============================================ -->
      <!-- Modernizer JS -->
      <script src="{{ asset('web-assets/js/vendor/modernizr-3.11.7.min.js') }}"></script>
      <!-- jquery -->
      <script src="{{ asset('web-assets/js/vendor/jquery-v3.6.0.min.js') }}"></script>
      <!-- Popper JS -->
      <script src="{{ asset('web-assets/js/vendor/popper.js') }}"></script>
      <!-- Bootstrap JS -->
      <script src="{{ asset('web-assets/js/vendor/bootstrap.min.js') }}"></script>
      <!-- headroom JS -->
      <script src="{{ asset('web-assets/js/plugins/headroom.min.js') }}"></script>
      <!-- headroom JS -->
      <script src="{{ asset('web-assets/js/plugins/jquery.headroom.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/owl-carousel.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/magnific-popup.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/images-loaded.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/isotope.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/jarallax.min.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/slick.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/easyzoom.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/resizesensor.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/sticky-sidebar.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/jquery-ui.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/jquery-ui-touch-punch.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/wow.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/tilt.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/select2.min.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/countdown.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/waypoints.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/counterup.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/jquery.appear.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/jquery.knob.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/scrollup.js') }}"></script>
      <script src="{{ asset('web-assets/js/plugins/ajax-mail.js') }}"></script>
      <!-- Main JS -->
      <script src="{{ asset('web-assets/js/main.js') }}"></script>
      <script>
         function toggleContainer() {
            const container = document.getElementById('expandableContainer');
            const content = document.getElementById('hiddenContent');
            const indicator = document.getElementById('indicator');
            const isMobile = window.matchMedia("(max-width: 768px)").matches;
            
            if (container.style.width === '70px' || !container.style.width) {
               // Expand - show white background and content
               container.style.width = isMobile ? '90vw' : '600px'; // Use viewport width on mobile
               container.style.maxWidth = isMobile ? '90vw' : '600px'; // Limit maximum width
               container.style.backgroundColor = 'white';
               content.style.display = 'block';
               indicator.style.transform = 'rotate(180deg)';
               
               // On mobile, adjust position to ensure visibility
               if (isMobile) {
               container.style.right = '5vw';
               container.style.top = '50%';
               }
            } else {
               // Collapse - back to transparent with just icon
               container.style.width = '70px';
               container.style.maxWidth = 'none';
               container.style.backgroundColor = 'transparent';
               content.style.display = 'none';
               indicator.style.transform = 'rotate(0deg)';
               
               // Reset mobile adjustments
               container.style.right = '';
               container.style.top = '';
            }
         }
      </script>
   </body>
</html>