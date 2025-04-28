<x-layouts.app>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ $heading ?? 'Settings' }}</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <!-- Settings Layout -->
            <div class="row mt-4">
                <!-- Sidebar Menu -->
                <div class="col-md-3 mb-4">
                    <div class="list-group">
                        <a href="{{ route('settings.profile') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.profile') ? 'active' : '' }}"
                           wire:navigate>
                            {{ __('Profile') }}
                        </a>
                        <a href="{{ route('settings.password') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.password') ? 'active' : '' }}"
                           wire:navigate>
                            {{ __('Password') }}
                        </a>
                        {{-- <a href="{{ route('settings.appearance') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.appearance') ? 'active' : '' }}"
                           wire:navigate>
                            {{ __('Appearance') }}
                        </a> --}}
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-md-9">
                    <div>
                        <div class="mt-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>