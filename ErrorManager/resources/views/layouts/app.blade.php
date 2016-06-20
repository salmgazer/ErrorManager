<html lang="en">
    <head>
        <title> {{ $page_title }}</title>

        @include('includes.head')
    </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top voda_background" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/images/vodafone-logo.png" id="small_logo">
                </a>
                <a class="navbar-brand" style="color: white;" href="/">
                    Vodafone
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle text-white" data-toggle="dropdown" href="#">
                        {{ Auth::user()->name }} &nbsp;&nbsp;<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down">
                        </i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw voda-text"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a class="active" href="/"><i class="fa fa-dashboard fa-fw voda-text"></i> Dashboard</a>
                        </li>
                        @if(Auth::user()->type == 'superadmin')
                            <li class="">
                                <a href="#"><i class="fa fa-users fa-1x voda-text"></i>&nbsp;&nbsp; Manage Users<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="/adduser"><i class="fa fa-plus-circle fa-1x voda-text"></i>&nbsp;&nbsp;Add User</a>
                                    </li>
                                    <li>
                                        <a href="/users"><i class="fa fa-edit fa-1x voda-text"></i>&nbsp;&nbsp;Existing Users</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @elseif(Auth::user()->type == 'admin')
                        <li class="">
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw voda-text"></i> Bulk Errors<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="/"><i class="fa fa-times voda-text"></i>&nbsp;&nbsp;Resolve Bulk Errors</a>
                                </li>
                                <li>
                                    <a href="/errors/statistics"><i class="fa fa-bar-chart-o fa-fw voda-text"></i>&nbsp;&nbsp;View Error Reports</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-history voda-text"></i> &nbsp;&nbsp; History</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @elseif(Auth::user()->type == 'front_office')
                        <li class="">
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Resole Errors<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="panels-wells.html">Resolve Error</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Report Error</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @else
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" style="min-height: 836px;">
            <div class="row">
                <div class="col-lg-12 page-header" style="margin-top: 20px;">
                    <a href="#">Home  > &nbsp;&nbsp;&nbsp;</a><a href="#">Add User  > &nbsp;&nbsp;&nbsp;</a>
                </div>
                <hr>
                <div>
                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <!-- /.row -->
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    @include('includes.jsarea')

</body></html>