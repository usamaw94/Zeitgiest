@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li class="active" ><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
        <li><a href="/garment"><i class="fa fa-link"></i> <span>Manage Garment</span></a></li>
    </ul>
@endsection

@section('content')
        <!-- Content Header (Page header) -->
    <div id="notify" class="box box-solid notify-panel">
        <p><i class="fa fa-check icon"></i>&nbsp;&nbsp;
            <span id="notifyText"></span>
        </p>
    </div>

    <section class="content-header">

        @if (session('msg'))
            <div id="staticNotify" class="callout callout-info">
                <h4><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;  {{ session('msg') }}</h4>
            </div>
        @endif

        @if ($errors->has('address'))
             <div id="staticErrorNotify" class="callout callout-danger">
                 <h4><i class="icon fa fa-info"></i>&nbsp;&nbsp;&nbsp;  {{ $errors->first('address') }}</h4>
             </div>
        @endif

        <h1>
            Shop Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                <h4 class="box-title">
                    Add New Shop
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="collapseTwo" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">
                        <form role="form" action="/addShop" method="post">
                            {{csrf_field()}}

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="shopAddress">Address</label>
                                    <input type="text" class="form-control" id="shopAddress" name="address" required placeholder="Enter complete address">
                                </div>
                                <div class="form-group">
                                    <label for="shopPassword">Password</label>
                                    <input type="text" class="form-control" id="shopPassword" name="password" required placeholder="Enter password">
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Shops Data</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    <div id="reload">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Shop ID</th>
                            <th>Address</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($shops as $s)
                            <tr>
                                <td>{{ $s->shop_id }}</td>
                                <td>{{ $s->s_address }}</td>
                                <td>{{ $s->s_password }}</td>
                                <td><i hint="tooltip" title="Edit" onclick="window.location.href='/editShop/{{ $s->shop_id }}'" class="fa fa-edit shop-action shop-action-edit"></i>
                                    <i hint="tooltip" title="Delete" data-shop-id="{{ $s->shop_id }}" data-toggle="modal" data-target="#deleteShop" class="fa fa-trash-o shop-action shop-action-delete"></i>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@section('modals')
    <div class="modal fade" id="deleteShop">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete shop</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete shop having ID : " <span id="idToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="delShop" class="btn btn-danger">Yes</div>
                    <button class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
