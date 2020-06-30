@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li class="active" ><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
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
            Fabric & Lining
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#tab_1-1" data-toggle="tab"><b>Fabric</b></a></li>
                <li><a href="#tab_2-2" data-toggle="tab"><b>Lining</b></a></li>
            </ul>
            <div class="tab-content" style="padding-top: 20px">

                <div class="tab-pane active" id="tab_1-1">

                    <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#fabric">
                <h4 class="box-title">
                    Add New Fabric
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="fabric" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">
                        <form role="form" action="/addFabric" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="fabricNum">Fabric Number</label>
                                    <input type="text" class="form-control" name="fabricNum" id="fabricNum" placeholder="Enter fabric number" required>
                                </div>
                                <div class="form-group">
                                    <label for="fabricImage">Fabric Image</label>
                                    <input type="file" id="fabricImage" name="fabricImg" required>

                                    <p class="help-block">Upload item image</p>
                                </div>
                                <div class="form-group">
                                    <label for="fabricStock">Stock</label>
                                    <input type="number" step="any" class="form-control" name="fabricStock" id="fabricStock" placeholder="Stock(meters)" required>
                                </div>
                                <label>Fabric will be available for</label><br>
                                <div class="checkbox-inline radio-danger">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="threePieceSuit" value="yes">
                                        3 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="twoPieceSuit" value="yes">
                                        2 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="jacket" value="yes">
                                        Jacket
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="waist_coat" value="yes">
                                        Waist Coat
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="pant" value="yes">
                                        Pant
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="shirt" value="yes">
                                        Shirt
                                    </label>
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
                <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Fabric List</h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="box-body no-padding">
                    <div id="fabricReload">
                        <table class="table table-striped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Number</th>
                            <th>Image</th>
                            <th>Stock(meters)</th>
                            <th>Available for</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($fabrics as $f)
                        <tr>
                            <td>{{ $f->itm_id }}</td>
                            <td>{{ $f->itm_num }}</td>
                            <td><img src="{{ $f->itm_img_src }}" alt="No image" class="item-img"></td>
                            <td>{{ $f->stock }}</td>
                            <td>
                                @if($f->three_piece_suit == 'yes' )
                                    (<b>3 Piece Suit</b>)
                                @endif
                                @if($f->two_piece_suit == 'yes' )
                                    (<b>2 Piece Suit</b>)
                                @endif
                                @if($f->jacket == 'yes' )
                                    (<b>Jacket</b>)
                                @endif
                                @if($f->waist_coat == 'yes' )
                                    (<b>Waist Coat</b>)
                                @endif
                                @if($f->pant == 'yes' )
                                    (<b>Pant</b>)
                                @endif
                                @if($f->shirt == 'yes' )
                                    (<b>Shirt</b>)
                                @endif
                            </td>
                            <td><i hint="tooltip" data-toggle="modal" data-target="#editFabricItem" title="Edit item" class="fa fa-edit item-action fabric-action-edit"
                                   data-item-id="{{ $f->itm_id }}"
                                   data-item-number="{{ $f->itm_num }}"
                                   data-fabric-stock="{{ $f->stock }}"
                                   data-item-img="{{ $f->itm_img_src }}"
                                   data-fabric-img-name="{{ $f->itm_img }}"
                                   data-three-piece="{{ $f->three_piece_suit }}"
                                   data-two-piece="{{ $f->two_piece_suit }}"
                                   data-jacket="{{ $f->jacket }}"
                                   data-waist-coat="{{ $f->waist_coat }}"
                                   data-pant="{{ $f->pant }}"
                                   data-shirt="{{ $f->shirt }}">
                                </i>
                                <i hint="tooltip" title="Delete" data-fabric-id="{{ $f->itm_id }}" data-fabric-num="{{ $f->itm_num }}" data-toggle="modal" data-target="#deleteFabricItem" class="fa fa-trash-o item-action fabric-action-delete"></i>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

                </div>

                <div class="tab-pane" id="tab_2-2">

                    <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#lining">
                <h4 class="box-title">
                    Add New Lining
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="lining" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">
                        <form role="form" action="/addLining" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="liningNum">Lining Number</label>
                                    <input type="text" class="form-control" name="liningNum" id="liningNum" placeholder="Enter lining number" required>
                                </div>
                                <div class="form-group">
                                    <label for="liningImage">Lining Image</label>
                                    <input type="file" id="liningImage" name="liningImg" required>

                                    <p class="help-block">Upload item image</p>
                                </div>
                                <div class="form-group">
                                    <label for="liningStock">Stock</label>
                                    <input type="number" step="any" class="form-control" name="liningStock" id="liningStock" placeholder="Enter stock(meters)" required>
                                </div>
                                <label>Lining will be available for</label><br>
                                <div class="checkbox-inline radio-danger">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="threePieceSuit" value="yes">
                                        3 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="twoPieceSuit" value="yes">
                                        2 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="jacket" value="yes">
                                        Jacket
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="waist_coat" value="yes">
                                        Waist Coat
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="pant" value="yes">
                                        Pant
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="shirt" value="yes">
                                        Shirt
                                    </label>
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
                <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Lining List</h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="box-body no-padding">
                    <div id="liningReload">
                        <table class="table table-striped table-hover">
                        <tr>
                            <th>Item Id</th>
                            <th>Item Number</th>
                            <th>Item Image</th>
                            <th>Stock(meters)</th>
                            <th>Available for</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($linings as $l)
                            <tr>
                                <td>{{ $l->itm_id }}</td>
                                <td>{{ $l->itm_num }}</td>
                                <td><img src="{{ $l->itm_img_src }}" alt="No image" class="item-img"></td>
                                <td>{{ $l->stock }}</td>
                                <td>
                                    @if($l->three_piece_suit == 'yes' )
                                        (<b>3 Piece Suit</b>)
                                    @endif
                                    @if($l->two_piece_suit == 'yes' )
                                        (<b>2 Piece Suit</b>)
                                    @endif
                                    @if($l->jacket == 'yes' )
                                        (<b>Jacket</b>)
                                    @endif
                                    @if($l->waist_coat == 'yes' )
                                        (<b>Waist Coat</b>)
                                    @endif
                                    @if($l->pant == 'yes' )
                                        (<b>Pant</b>)
                                    @endif
                                    @if($l->shirt == 'yes' )
                                        (<b>Shirt</b>)
                                    @endif
                                </td>
                                <td><i hint="tooltip" data-toggle="modal" data-target="#editLiningItem" title="Edit item" class="fa fa-edit item-action lining-action-edit"
                                       data-item-id="{{ $l->itm_id }}"
                                       data-lining-number="{{ $l->itm_num }}"
                                       data-lining-stock="{{ $l->stock }}"
                                       data-item-img="{{ $l->itm_img_src }}"
                                       data-lining-img-name="{{ $l->itm_img }}"
                                       data-three-piece="{{ $l->three_piece_suit }}"
                                       data-two-piece="{{ $l->two_piece_suit }}"
                                       data-jacket="{{ $l->jacket }}"
                                       data-waist-coat="{{ $l->waist_coat }}"
                                       data-pant="{{ $l->pant }}"
                                       data-shirt="{{ $l->shirt }}">
                                    </i>
                                    <i hint="tooltip" title="Delete" data-lining-id="{{ $l->itm_id }}" data-lining-num="{{ $l->itm_num }}" data-toggle="modal" data-target="#deleteLiningItem" class="fa fa-trash-o item-action lining-action-delete"></i>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

                </div>

            </div>
            <!-- /.tab-content -->
        </div>


    </section>
    <!-- /.content -->

@endsection

@section('modals')

    <div class="modal fade" id="editFabricItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/editFabric" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit fabric item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="displayImg" class="col-md-4">
                                <img id="modalFabricImg" class="img-responsive">
                                <div id="resetFabricImg" style="margin-top: 5px" class="btn btn-block btn-default"><b>Reset image changes</b></div>
                            </div>
                            <div class="col-md-8">
                                <input name="fabricId" id="modalFabricId" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="modalfabricNum">Item Number</label>
                                    <input name="fabricNum" id="modalfabricNum" type="text" class="form-control" placeholder="Enter number">
                                    <input name="fabricImgName" id="modalfabricImgName" type="hidden" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="mfabricStock">Stock</label>
                                    <input name="fabricStock" class="form-control" type="number" step="any" id="mfabricStock">
                                </div>
                                <div id="imgHandling">
                                    <div class="form-group">
                                        <label for="fmchangeImg">Change Image</label>
                                        <input type="file" name="fabricChangedImg" id="fmchangeImg">

                                        <p class="help-block">Upload new image</p>
                                        <input type="hidden" id="fdelStatus" readonly>
                                    </div>
                                </div>
                                <label>Fabric will be available for</label><br>
                                <div class="checkbox-inline radio-danger">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMThreePiece" name="threePieceSuit" value="yes">
                                        3 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMTwoPiece" name="twoPieceSuit" value="yes">
                                        2 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMJacket" name="jacket" value="yes">
                                        Jacket
                                    </label>
                                </div>
                                <br>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMWaistCoat" name="waist_coat" value="yes">
                                        Waist Coat
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMPant" name="pant" value="yes">
                                        Pant
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="fMShirt" name="shirt" value="yes">
                                        Shirt
                                    </label>
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
    <!-- /.modal -->

    <div class="modal fade" id="deleteFabricItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete fabric item</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete item having Fabric Number : " <span style="display: none;" id="fabricIdToDelete"></span><span id="fabricNumToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div type="button" class="btn btn-danger" id="delFabric">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="editLiningItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/editLining" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit lining item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="displayLImg" class="col-md-4">
                                <img id="modalLiningImg" class="img-responsive">
                                <div id="resetLiningImg" style="margin-top: 5px" class="btn btn-block btn-default"><b>Reset image changes</b></div>
                            </div>
                            <div class="col-md-8">
                                <input name="liningId" id="modalLiningId" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="modalLiningNum">Item Number</label>
                                    <input name="liningNum" id="modalLiningNum" type="text" class="form-control" placeholder="Enter name">
                                    <input name="liningImgName" id="modalliningImgName" type="hidden" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="mliningStock">Stock</label>
                                    <input name="liningStock" class="form-control" type="number" step="any" id="mliningStock">
                                </div>
                                <div id="imgLHandling">
                                    <div class="form-group">
                                        <label for="lmchangeImg">Change Image</label>
                                        <input name="liningChangedImg" type="file" id="lmchangeImg">

                                        <p class="help-block">Upload new image</p>
                                    </div>
                                </div>
                                <label>Lining will be available for</label><br>
                                <div class="checkbox-inline radio-danger">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMThreePiece" name="threePieceSuit" value="yes">
                                        3 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMTwoPiece" name="twoPieceSuit" value="yes">
                                        2 Piece Suit
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMJacket" name="jacket" value="yes">
                                        Jacket
                                    </label>
                                </div>
                                <br>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMWaistCoat" name="waist_coat" value="yes">
                                        Waist Coat
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMPant" name="pant" value="yes">
                                        Pant
                                    </label>
                                </div>
                                <div class="checkbox-inline">
                                    <label style="font-weight: normal">
                                        <input type="checkbox" id="lMShirt" name="shirt" value="yes">
                                        Shirt
                                    </label>
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
    <!-- /.modal -->

    <div class="modal fade" id="deleteLiningItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete lining item</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete item having Lining Number : " <span style="display: none;" id="liningIdToDelete"></span><span id="liningNumToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div type="button" class="btn btn-danger" id="delLining">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection
