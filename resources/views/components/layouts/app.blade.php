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
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <x-layouts.app.tree_css />

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