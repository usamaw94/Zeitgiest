@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li class="active"><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
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

        <h1>
            List Mangement
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; List Info</h3>
            </div>
            <div class="box-body">
                <h4>Cities List</h4>
            </div>
        </div>

        <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                <h4 class="box-title">
                    Add New City
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="collapseTwo" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">
                            <form role="form" action="/addCity" method="post">

                                {{ csrf_field() }}

                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="itemName">City Name</label>
                                        <input type="text" name="cityName" class="form-control" id="itemName" placeholder="Enter city name" required>
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
                <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Cities</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                        <div id="reload">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($cities as $c)
                            <tr>
                                <td>{{ $c->city_id }}</td>
                                <td>{{ $c->city_name }}</td>
                                <td><i hint="tooltip" data-item-id="{{ $c->city_id }}" data-item-name="{{ $c->city_name }}"
                                       data-toggle="modal" data-target="#editListItem" title="Edit item"
                                       class="fa fa-edit item-action item-action-edit-city"></i>
                                    <i hint="tooltip" title="Delete" data-item-id="{{ $c->city_id }}" data-item-name="{{ $c->city_name }}"
                                       data-toggle="modal" data-target="#deleteListItem"
                                       class="fa fa-trash-o item-action item-action-delete-city"></i>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('modals')

    <div class="modal fade" id="editListItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit list item</h4>
                </div>
                <form id="newItemData">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input name="mItemID" id="modalItemId" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="modalItemName">Item Name</label>
                                    <input name="mItemName" id="modalItemName" type="text" class="form-control" placeholder="Enter name">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button id="saveCity" class="btn btn-primary pull-left">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="deleteListItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove city</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to remove city : " <span id="cityName"></span><span style="display: none" id="idToDelete"></span>" from list ?
                    </p>
                </div>
                <div class="modal-footer">
                    <div type="button" class="btn btn-danger" id="delCity">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection