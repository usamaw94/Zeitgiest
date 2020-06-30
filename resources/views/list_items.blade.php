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
                <h4>List Id : <b>{{ $lst[0]->li_id }}</b></h4>
                <h4>Name : <b>{{ $lst[0]->li_name }}</b></h4>
                <h5>Image status : <b>{{ $lst[0]->img_status }}</b></h5>
            </div>
        </div>

        <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                <h4 class="box-title">
                    Add New Item
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="collapseTwo" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">
                        @if( $lst[0]->img_status == 'yes')
                            <form role="form" action="/addImgItem" method="post" enctype="multipart/form-data">

                                {{ csrf_field() }}

                                <div class="box-body">
                                    <input type="hidden" name="listId" value="{{ $lst[0]->li_id }}">
                                    <input type="hidden" name="listName" value="{{ $lst[0]->li_name }}">
                                    <div class="form-group">
                                        <label for="itemName">Item Name</label>
                                        <input type="text" name="itemName" class="form-control" id="itemName" placeholder="Enter complete address">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Item Image</label>
                                        <input type="file" name="itemImg" id="itmImg">

                                        <p class="help-block">Upload item image</p>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        @elseif( $lst[0]->img_status == 'no')
                            <form role="form" action="/addItem" method="post">

                                {{ csrf_field() }}

                                <div class="box-body">
                                    <input type="hidden" name="listId" value="{{ $lst[0]->li_id }}">
                                    <input type="hidden" name="listName" value="{{ $lst[0]->li_name }}">
                                    <div class="form-group">
                                        <label for="itemName">Item Name</label>
                                        <input type="text" name="itemName" class="form-control" id="itemName" placeholder="Enter complete address">
                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; List items</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    @if( $lst[0]->img_status == 'yes')
                        <div id="reload">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Item Image</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($listItems as $lis)
                            <tr>
                                <td>{{ $lis->itm_id }}</td>
                                <td>{{ $lis->itm_name }}</td>
                                <td><img src="{{ $lis->itm_img_src }}" alt="No image" class="item-img"></td>
                                <td><i hint="tooltip" id="editImgItem" data-item-id="{{ $lis->itm_id }}" data-item-name="{{ $lis->itm_name }}"
                                       data-item-img="{{ $lis->itm_img_src }}" data-img_name="{{ $lis->itm_img }}"
                                       data-list-id="{{ $lst[0]->li_id }}"
                                       data-toggle="modal" data-target="#editImgListItem" title="Edit item" class="fa fa-edit item-action item-action-edit"></i>
                                    <i hint="tooltip" title="Delete" data-item-id="{{ $lis->itm_id }}" data-list-id="{{ $lst[0]->li_id }}" data-toggle="modal" data-target="#deleteListItem" class="fa fa-trash-o item-action item-action-delete"></i>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                    @elseif( $lst[0]->img_status == 'no')
                        <div id="reload">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($listItems as $lis)
                            <tr>
                                <td>{{ $lis->itm_id }}</td>
                                <td>{{ $lis->itm_name }}</td>
                                <td><i hint="tooltip" id="editItem" data-item-id="{{ $lis->itm_id }}" data-item-name="{{ $lis->itm_name }}" data-list-id="{{ $lst[0]->li_id }}"
                                       data-toggle="modal" data-target="#editListItem" title="Edit item"
                                       class="fa fa-edit item-action item-action-edit"></i>
                                    <i hint="tooltip" title="Delete" data-item-id="{{ $lis->itm_id }}" data-list-id="{{ $lst[0]->li_id }}"
                                       data-toggle="modal" data-target="#deleteListItem"
                                       class="fa fa-trash-o item-action item-action-delete"></i>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('modals')

    <div class="modal fade" id="editImgListItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/editImgItem" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit list item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="displayImg" class="col-md-4">
                                <img id="modalItemImg" class="img-responsive">
                                <div id="resetImg" style="margin-top: 5px" class="btn btn-block btn-default"><b>Reset image changes</b></div>
                                <div id="removeImg" style="margin-top: 5px" class="btn btn-block btn-danger"><b>Remove image</b></div>
                            </div>
                            <div class="col-md-8">
                                <input id="modalImgListId" name="listId" type="hidden" readonly>
                                <input id="modalImgItemId" name="itemId" type="hidden" readonly>
                                <input id="modalOrigImg" name="oldImg" type="hidden" readonly>
                                <input id="imgName" name="imgName" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="modalImgItemName">Item Name</label>
                                    <input id="modalImgItemName" name="ImgItmName" type="text" class="form-control" placeholder="Enter name">
                                </div>
                                <div id="imgHandling">
                                    <div class="form-group">
                                        <label for="changeImg">Change Image</label>
                                        <input type="file" id="changeImg" name="itmImage">

                                        <p class="help-block">Upload new image</p>
                                        <input type="hidden" id="delStatus" name="delStatus" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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
                                <input name="mListID" id="modalListId" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="modalItemName">Item Name</label>
                                    <input name="mItemName" id="modalItemName" type="text" class="form-control" placeholder="Enter name">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button id="saveItem" class="btn btn-primary pull-left">Save changes</button>
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
                    <h4 class="modal-title">Delete list item</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete item having ID : " <span id="idToDelete"></span>
                        <span id="listID"></span>" ?
                    </p>
                </div>
                <div class="modal-footer">
                    <div type="button" class="btn btn-danger" id="delItem">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection