<div class="header">
    <div class="pull-left">
        <div class="logo"><a wire:navigate href="{{ route('dashboard') }}"><img src="{{ asset('assets/logo-color.png') }}" alt="" style="height: 25px;margin-right: 9px;" /><span>Ashor Alo Admin</span></a></div>
        <div class="hamburger sidebar-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>

    <div class="pull-right p-r-15">
        <ul>
            <li class="header-icon dib"><i class="ti-bell"></i>
                <div class="drop-down">
                    <div class="dropdown-content-heading">
                        <span class="text-left">Recent Notifications</span>
                    </div>
                    <div class="dropdown-content-body">
                        <ul>
                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/3.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">5 members joined today </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/3.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">likes a photo of you</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/3.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/3.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="#" class="more-link">See All</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="header-icon dib"><i class="ti-email"></i>
                <div class="drop-down">
                    <div class="dropdown-content-heading">
                        <span class="text-left">2 New Messages</span>
                        <a href="email.html"><i class="ti-pencil-alt pull-right"></i></a>
                    </div>
                    <div class="dropdown-content-body">
                        <ul>
                            <li class="notification-unread">
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/1.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>

                            <li class="notification-unread">
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/2.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/3.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pull-left m-r-10 avatar-img" src="{{ asset('assets/images/avatar/2.jpg') }}" alt="" />
                                    <div class="notification-content">
                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                        <div class="notification-heading">Mr.  Ajay</div>
                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                    </div>
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="#" class="more-link">See All</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="header-icon dib">
                @if (auth()->user()->hasMedia('user'))
                <img class="avatar-img" src="{{ auth()->user()->getFirstMediaUrl('user') }}" alt="" /> 
                @endif
                <span class="user-avatar"> {{ auth()->user()->name }} <i class="ti-angle-down f-s-10"></i></span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-heading">
                        <span class="text-left">{{ auth()->user()->name }}</span>
                        <p class="trial-day">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="dropdown-content-body">
                        <ul>
                            <li>
                                <a wire:navigate href="{{ route('settings.profile') }}">
                                    <i class="ti-settings"></i> <span>Setting</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-head').submit();">
                                   <i class="ti-power-off"></i> <span>Logout</span>
                                </a>
                            </li>
                            
                            <form id="logout-form-head" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>