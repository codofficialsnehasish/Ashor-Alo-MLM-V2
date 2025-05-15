{{-- <x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? '' }} @if(isset($title))| @endif {{ config('app.name', 'Ashor Alo') }}</title>
	
	<!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon--> 
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon--> 
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <link href="{{ asset('assets/css/lib/chartist/chartist.min.css') }}" rel="stylesheet">
	<!-- Styles -->
    <link href="{{ asset('assets/css/lib/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/lib/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/themify-icons.css') }}" rel="stylesheet"> 
    <link href="{{ asset('assets/css/lib/menubar/sidebar.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/css/lib/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/unix.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/select2/css/select2.min.css') }}"></script>
    
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
    .n-ppost-name{
        top: 0;
        left: 66%;
        margin-top: 10px;
        width: 460px;
        opacity: 0;
        -webkit-transform: translate3d(0, -15px, 0);
        transform: translate3d(0, -15px, 0);
        -webkit-transition: all 150ms linear;
        -o-transition: all 150ms linear;
        transition: all 150ms linear;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.4;
        visibility: hidden;
        pointer-events: none;
        position: absolute;
        background: #79cf3ed1;
        color: #000;
        padding: 10px;
        z-index: 999999999999;
    }

    .n-ppost:hover + .n-ppost-name {
        opacity: 1;
        visibility: visible;
        -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
    }

    .left {
        float: left;
        width: 50%;
    }

    .left .element {
        float: left;
        width: 100%;
        text-align: left;
    }

    .right {
        float: left;
        width: 50%;
    }
    .right .element {
        float: left;
        width: 100%;
        text-align: left;
    }
    .left .element label {
        float: left;
        width: 43%;
    }
    .right .element label {
        float: left;
        width: 43%;
    }

    .n-ppost-name .element {
        text-align: left;
    }
    /*----------------genealogy-scroll----------*/

    .genealogy-scroll::-webkit-scrollbar {
        width: 5px;
        height: 8px;
    }
    .genealogy-scroll::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: #e4e4e4;
    }
    .genealogy-scroll::-webkit-scrollbar-thumb {
        background: #212121;
        border-radius: 10px;
        transition: 0.5s;
    }
    .genealogy-scroll::-webkit-scrollbar-thumb:hover {
        background: #d5b14c;
        transition: 0.5s;
    }


    /*----------------genealogy-tree----------*/
    .genealogy-body{
        white-space: nowrap;
        overflow-y: visible;
        padding: 50px;
        min-height: 500px;
        padding-top: 10px;
        text-align: center;
    }
    .genealogy-tree{
        display: inline-block;
    }
    .genealogy-tree ul {
        padding-top: 20px; 
        position: relative;
        padding-left: 0px;
        display: flex;
        justify-content: center;
    }
    .genealogy-tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;
    }
    .genealogy-tree li::before, .genealogy-tree li::after{
        content: '';
        position: absolute; 
        top: 0; 
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%; 
        height: 18px;
    }
    .genealogy-tree li::after{
        right: auto; left: 50%;
        border-left: 2px solid #ccc;
    }
    .genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
        display: none;
    }
    .genealogy-tree li:only-child{ 
        padding-top: 0;
    }
    .genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
        border: 0 none;
    }
    .genealogy-tree li:last-child::before{
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .genealogy-tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }
    .genealogy-tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 2px solid #ccc;
        width: 0; height: 20px;
    }
    .genealogy-tree li a{
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
    }

    .genealogy-tree li a:hover, 
    .genealogy-tree li a:hover+ul li a {
        background: #c8e4f8;
        color: #000;
    }

    .genealogy-tree li a:hover+ul li::after, 
    .genealogy-tree li a:hover+ul li::before, 
    .genealogy-tree li a:hover+ul::before, 
    .genealogy-tree li a:hover+ul ul::before{
        border-color:  #fbba00;
    }

    /*--------------memeber-card-design----------*/

    .member-view-box{
        /* padding-bottom: 10px; */
        text-align: center;
        /* border-radius: 4px; */
        position: relative;
        /* border: 1px; */
        /* border-color: #e4e4e4; */
        /* border-style: solid; */
    }
    .member-image{
        padding:10px;
        width: 100%;
        position: relative;
    }
    .member-image img{
        width: 100px;
        height: 100px;
        border-radius: 6px;
        background-color :#fff;
        z-index: 1;
    }
    .member-header-active {
        padding: 5px 0;
        text-align: center;
        background: #02a499;
        color: #fff;
        font-size: 14px;
        border-radius: 4px 4px 0 0;
    }
    .member-header-inactive {
        padding: 5px 0;
        text-align: center;
        background: #ec4561;
        color: #fff;
        font-size: 14px;
        border-radius: 4px 4px 0 0;
    }
    .member-footer {
        text-align: center;
    }
    .member-footer div.name {
        color: #000;
        /* font-size: 14px; */
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .member-footer div.emptyname {
        padding: 12px;
    }
    
    .member-footer div.downline {
        color: #000;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-overlay .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>
    @livewireStyles
</head>

<body>
    <x-layouts.app.sidebar />
     

    <x-layouts.app.header />

    {{ $slot }}

    @livewireScripts
    <x-layouts.app.scripts />

    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            //  $('.js-example-basic-multiple').select2();
            Livewire.on('toastMessage', event => {
                const e = JSON.parse(event);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right"
                }
                if (e.type === 'success') {
                    toastr.success(e.message);
                } else if (e.type === 'error') {
                    toastr.error(e.message);
                } else if (e.type === 'warning') {
                    toastr.warning(e.message);
                } else if (e.type === 'info') {
                    toastr.info(e.message);
                }
            });

            Livewire.on('swal:success', event => {
                const jsonData = JSON.parse(event);
                Swal.fire({
                    title: jsonData.title,
                    text: jsonData.text,
                    icon: jsonData.icon,
                });
            });
        });
    </script>
</body>

</html>