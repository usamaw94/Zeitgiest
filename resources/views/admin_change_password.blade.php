@extends('layouts.customAdmin')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
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
                <h4><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;  {{ session('msg') }}</h4>
            </div>
        @endif

        @if (session('errorMsg'))
            <div id="staticErrorNotify" class="callout callout-danger">
                <h4><i class="icon fa fa-times"></i>&nbsp;&nbsp;&nbsp;  {{ session('errorMsg') }}</h4>
            </div>
        @endif

        <h1>
            Change Password
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-primary">
            <div class="box-body">
                <div class="col-md-offset-3 col-md-6">
                    <div class="box-body">
                        <form action="/adminChangeRequest" method="post">
                            {{ csrf_field() }}
                            <h4>Enter current password</h4>
                            <input type="password" name="currentPassword" class="form-control" required>
                            <h4>Enter new password</h4>
                            <input type="password" name="newPassword" class="form-control" required>
                            @if ($errors->has('newPassword'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                            @endif
                            <br>
                            <button class="btn btn-primary" type="submit">
                                <b>Change Password</b>
                            </button>
                        </form>
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
