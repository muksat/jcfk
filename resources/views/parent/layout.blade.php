<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Just Catering For Kids</title>
    <link rel="stylesheet" href="/css/parent/app.css"/>
</head>
<body>
<div id="wrapper">
    @section('side-nav')
        @include('parent.nav')
    @show

    <!-- Page Content -->
    <div id="@yield('page-wrapper', 'page-wrapper')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome</h1>
                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script src="/js/parent/bundle.js"></script>
</body>

</html>
