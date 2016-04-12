<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('admin::dashboard') }}">Just Catering For Kids</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    <a href="{{ route('admin::dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin::meal.index') }}"><i class="fa fa-cutlery fa-fw"></i> Manage Meals</a>
                </li>
                <li>
                    <a href="{{ route('admin::school.index') }}"><i class="fa fa-university fa-fw"></i> Manage Schools</a>
                </li>
                <li>
                    <a href="{{ route('admin::orderForms') }}"><i class="fa fa-table fa-fw"></i> Manage order forms</a>
                </li>
                 <li>
                       <a href="{{ route('admin::teacher.index') }}"><i class="fa fa-child fa-fw"></i> Manage Teachers</a>
                 </li>
                 <li>
                    <a href="{{ route('admin::student.index') }}"><i class="fa fa-child fa-fw"></i> Manage Students</a>
                 </li>

                <li>
                    <a href="{{ route('admin::parent.index') }}"><i class="fa fa-user fa-fw"></i> Manage Parents</a>
                </li>
                <li>
                    <a href="{{ route('admin::user.index') }}"><i class="fa fa-lock fa-fw"></i> Manage Admins</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>