@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
        <li><a href="/garment"><i class="fa fa-link"></i> <span>Manage Garment</span></a></li>
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
        Dashboard
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
            <div class="info-box" onclick="window.location.href='/shops'" style="cursor: pointer">
                <span class="info-box-icon bg-aqua"><i class="fa fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">Shop <br>Management</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/orders'" style="cursor: pointer">
                <span class="info-box-icon bg-red"><i class="fa fa-shopping-bag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">Order <br>Management</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/lists'" style="cursor: pointer">
                <span class="info-box-icon bg-green"><i class="ion ion-android-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">List <br>Management</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/fabricLining'" style="cursor: pointer">
                <span class="info-box-icon bg-maroon"><img src="/icons/fabric.png"></span>

                <div class="info-box-content">
                    <span class="info-box-number">Fabric &<br>Linning</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" onclick="window.location.href='/garment'" style="cursor: pointer">
                <span class="info-box-icon bg-teal"><img src="/icons/garment-50.png"></span>

                <div class="info-box-content">
                    <span class="info-box-number">Garment <br>Management</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
@endsection
