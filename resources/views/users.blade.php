@extends('layouts.customAdmin')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li class="active"><a href="/users"><i class="fa fa-user"></i> <span>Manage Users</span></a></li>
        <li><a href="/adminOrders"><i class="fa fa-shopping-bag"></i> <span>View Orders</span></a></li>
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
        <h1>
            Users Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Users List</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    <div id="usersReload">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Activation Status</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->status == 'Active')
                                <i class="fa fa-check active-user" hint="tooltip" title="Active User"></i>
                                @elseif($u->status == 'Deactive')
                                <i class="fa fa-times deactive-user" hint="tooltip" title="De-active User"></i></td>
                                @endif

                            <td>
                                @if($u->status == 'Deactive')
                                <i data-user-id="{{ $u->id }}" hint="tooltip" title="Activate User" data-toggle="modal" data-target="#activateUser" class="fa fa-user-plus user-action user-action-activate"></i>
                                @elseif($u->status == 'Active')
                                <i data-user-id="{{ $u->id }}" hint="tooltip" title="De-activate User" data-toggle="modal" data-target="#deactivateUser" class="fa fa-user-times user-action user-action-deactivate"></i>
                                @endif
                                    <i hint="tooltip" title="Show Password" data-user-id="{{ $u->id }}" data-toggle="modal" data-target="#showPassword" class="fa fa-lock user-action user-action-show-password"></i>
                                <i data-user-id="{{ $u->id }}" hint="tooltip" title="Delete User" data-toggle="modal" data-target="#deleteUser" class="fa fa-trash-o user-action user-action-delete"></i>
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

    <div class="modal fade" id="showPassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">User Password</h4>
                </div>
                <div class="modal-body">
                    <div id="adminPasswordDiv">
                        <h5>Enter admin password</h5>
                        <div class="input-group">
                            <form id="showingPassword">
                            <input type="hidden" id="idToShowPassword" name="userId">
                            <input type="password" class="form-control" name="adminPass" id="aPassword" required>
                            </form>
                            <span class="input-group-btn">
                            <div id="showUserPassword" class="btn btn-primary">
                                <i class="fa fa-unlock-alt"></i>
                            </div>
                            </span>
                        </div>
                    </div>
                    <div id="passwordDiv">
                        <h4 id="uPassword"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="deleteUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete user</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete user having ID : " <span id="idToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="confirmDeleteUser" class="btn btn-danger">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="activateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Activate user</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to activate user having ID : " <span id="idToActivate"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="confirmActivateUser" class="btn btn-primary">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="deactivateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deactivate user</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to de-activate user having ID : " <span id="idToDeactivate"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="confirmDeactivateUser" class="btn btn-primary">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
