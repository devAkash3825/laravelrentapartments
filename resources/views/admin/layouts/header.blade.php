<div class="slim-header">
    <div class="container">
        <div class="slim-header-left">
            <h2 class="slim-logo"><a href="index.html">slim<span>.</span></a></h2>

            <div class="search-box">
                <input type="text" class="form-control" placeholder="Search">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="slim-header-right">
            <div class="dropdown dropdown-b">
                <a href="" class="header-notification" data-toggle="dropdown">
                    <i class="icon ion-ios-bell-outline"></i>
                    <span class="indicator"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-menu-header">
                        <h6 class="dropdown-menu-title">Notifications</h6>
                        <div>
                            <a href="">Mark All as Read</a>
                            <a href="">Settings</a>
                        </div>
                    </div>
                    <div class="dropdown-list">
                        <a href="" class="dropdown-link">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p><strong>Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                                    <span>October 03, 2017 8:45am</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="dropdown-link">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p><strong>Mellisa Brown</strong> appreciated your work <strong>The Social Network</strong></p>
                                    <span>October 02, 2017 12:44am</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="dropdown-link read">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p>20+ new items added are for sale in your <strong>Sale Group</strong></p>
                                    <span>October 01, 2017 10:20pm</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="dropdown-link read">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p><strong>Julius Erving</strong> wants to connect with you on your conversation with <strong>Ronnie Mara</strong></p>
                                    <span>October 01, 2017 6:08pm</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-list-footer">
                            <a href="page-notifications.html"><i class="fa fa-angle-down"></i> Show All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown dropdown-c">
                <a href="#" class="logged-user" data-toggle="dropdown">
                    <img src="" alt="">
                    <span>Katherine</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <nav class="nav">
                        <a href="page-profile.html" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                        <a href="page-edit-profile.html" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
                        <a href="page-activity.html" class="nav-link"><i class="icon ion-ios-bolt"></i> Activity Log</a>
                        <a href="page-settings.html" class="nav-link"><i class="icon ion-ios-gear"></i> Account Settings</a>
                        <a href="{{ route('admin.logout')}}" class="nav-link"><i class="icon ion-forward"></i> Sign Out</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="slim-navbar">
    <div class="container">
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-house mr-1 mb-1"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-users mr-1"></i>
                    <span> Client </span>
                </a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{ route('admin.add.renter')}}">Add New Renter</a></li>
                        <li><a href="{{ route('admin.active.renter')}}">Active Renters</a></li>
                        <li><a href="page-contact.html">Contact Manager</a></li>
                        <li><a href="page-file-manager.html">File Manager</a></li>
                        <li><a href="page-calendar.html">Calendar</a></li>
                        <li><a href="page-timeline.html">Timeline</a></li>
                        <li class="sub-with-sub">
                            <a href="#">Pricing</a>
                            <ul>
                                <li><a href="page-pricing.html">Pricing 01</a></li>
                                <li><a href="page-pricing2.html">Pricing 02</a></li>
                                <li><a href="page-pricing3.html">Pricing 03</a></li>
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="page-signin.html">Sign In</a>
                            <ul>
                                <li><a href="page-signin.html">Signin Simple</a></li>
                                <li><a href="page-signin2.html">Signin Split</a></li>
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="page-signup.html">Sign Up</a>
                            <ul>
                                <li><a href="page-signup.html">Signup Simple</a></li>
                                <li><a href="page-signup2.html">Signup Split</a></li>
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Error Pages</a>
                            <ul>
                                <li><a href="page-404.html">404 Not Found</a></li>
                                <li><a href="page-505.html">505 Forbidden</a></li>
                                <li><a href="page-500.html">500 Internal Server</a></li>
                                <li><a href="page-503.html">503 Service Unavailable</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
