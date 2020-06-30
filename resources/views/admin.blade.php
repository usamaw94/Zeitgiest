@extends('layouts.customAdmin')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/users"><i class="fa fa-user"></i> <span>Manage Users</span></a></li>
        <li><a href="/adminOrders"><i class="fa fa-shopping-bag"></i> <span>View Orders</span></a></li>
    </ul>
@endsection


@section('content')
        <!-- Content Header (Page header) -->
<section class="content-header">
    @if (session('msg'))
        <div id="staticNotify" class="callout callout-info">
            <h4><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;  {{ session('msg') }}</h4>
        </div>
    @endif
    <h1>
        Admin Dashboard
    </h1>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!--------------------------
      | Your Page Content Here |
      -------------------------->

    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/users'" style="cursor: pointer">
                <span class="info-box-icon bg-navy"><i class="fa fa-user"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">User <br>Management</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/adminOrders'" style="cursor: pointer">
                <span class="info-box-icon bg-red"><i class="fa fa-shopping-bag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">View <br>Orders</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
@endsection
