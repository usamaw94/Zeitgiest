@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li class="active"><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
        <li><a href="/garment"><i class="fa fa-link"></i> <span>Manage Garment</span></a></li>
    </ul>
@endsection

@section('content')

        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Shop Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit"></i>&nbsp; Edit Shop</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">

                    <div class="col-md-offset-2 col-md-8">
                        <form role="form" action="/updateShop" method="post">
                            {{ csrf_field() }}

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="shopId">Shop Id</label>
                                    <input type="text" name="Id" class="form-control" id="shopId" placeholder="Enter complete address" readonly value="{{ $shop[0]->shop_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="shopAddress">Address</label>
                                    <textarea name="address" class="form-control" id="shopAddress" placeholder="Enter complete address" required>{{ $shop[0]->s_address }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="shopPassword">Password</label>
                                    <input name="password" value="{{ $shop[0]->s_password }}" type="text" class="form-control" id="shopPassword" placeholder="Enter password" required>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <button type="button" onclick="window.location.href='/shops'" class="btn btn-default pull-right">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection