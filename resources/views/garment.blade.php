@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
        <li class="active"><a href="/garment"><i class="fa fa-link"></i> <span>Manage Garment</span></a></li>
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
            Garment Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#tab_1-1" data-toggle="tab"><b>Garment Consumption</b></a></li>
                <li><a href="#tab_2-2" data-toggle="tab"><b>Base Size</b></a></li>
                <li><a href="#tab_3-2" data-toggle="tab"><b>Base Pattern</b></a></li>
            </ul>
            <div class="tab-content" style="padding-top: 20px">
                <div class="tab-pane active" id="tab_1-1">
                    <div id="garmentReload">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Garment Id</th>
                            <th>Garment Name</th>
                            <th>Fabric Consumption</th>
                            <th>Lining Consumption</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($garments as $g)
                        <tr>
                            <td>{{ $g->garment_id }}</td>
                            <td>{{ $g->garment_name }}</td>
                            <td>{{ $g->fabric_consumption }}</td>
                            <td>{{ $g->lining_consumption }}</td>
                            <td><i data-toggle="modal" data-target="#editGarment" title="Edit consumption" class="fa fa-edit item-action garment-action-edit" hint="tooltip"
                                   data-garment-id="{{ $g->garment_id }}"
                                   data-garment-name="{{ $g->garment_name }}"
                                   data-fabric-consumption="{{ $g->fabric_consumption }}"
                                   data-lining-consumption="{{ $g->lining_consumption }}">
                                </i>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2-2">
                    <div class="panel box box-solid" style="background: #3c8dbc">
                        <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <h4 class="box-title">
                                Add New Base Size
                            </h4>
                        </div>
                        <div style="background-color: #fff; border-radius: 2px" id="collapseTwo" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="col-md-offset-2 col-md-8">
                                    <form role="form" action="/addBaseSize" method="post">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="baseSize">Base Size</label>
                                                <input type="text" name="bSize" class="form-control" id="baseSize" placeholder="Enter base size">
                                            </div>
                                            <div class="form-group">
                                                <label for="baseGarment">Select garment</label>
                                                <select class="form-control" name="bGarment" id="baseGarment">
                                                    @foreach($garments as $gBS)
                                                    <option value="{{ $gBS->garment_id }}">{{ $gBS->garment_name }}</option>
                                                    @endforeach
                                                </select>
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
                            <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Base Sizes List</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-body no-padding">
                                <div id="baseSizeReload">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Base Size</th>
                                        <th>Garment</th>
                                        <th>Actions</th>
                                    </tr>
                                    @foreach($baseSizes as $bs)
                                    <tr>
                                        <td>{{ $bs->base_size_id }}</td>
                                        <td>{{ $bs->base_size }}</td>
                                        <td>{{ $bs->garment_name }}</td>
                                        <td><i hint="tooltip" title="Edit" data-toggle="modal" data-target="#editBaseSize" class="fa fa-edit shop-action base-size-action-edit"
                                               data-bs-id="{{ $bs->base_size_id }}"
                                               data-bs-bs="{{ $bs->base_size }}"
                                               data-bs-garment="{{ $bs->garment_id }}"></i>
                                            <i hint="tooltip" title="Delete" data-bs-id="{{ $bs->base_size_id }}" data-toggle="modal" data-target="#deleteBaseSize" class="fa fa-trash-o shop-action base-size-action-delete"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3-2">

                    <div class="panel box box-solid" style="background: #3c8dbc">
                        <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <h4 class="box-title">
                                Add New Base Pattern
                            </h4>
                        </div>
                        <div style="background-color: #fff; border-radius: 2px" id="collapseThree" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="col-md-offset-2 col-md-8">
                                    <form role="form" action="/addBasePattern" method="post">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="basePattern">Base Pattern</label>
                                                <input name="bPattern" type="text" class="form-control" id="basePattern" placeholder="Enter base pattern">
                                            </div>
                                            <div class="form-group">
                                                <label for="basePGaremnt">Select garment</label>
                                                <select name="bPGarment" class="form-control" id="basePGaremnt">
                                                    @foreach($garments as $gBP)
                                                        <option value="{{ $gBP->garment_id }}">{{ $gBP->garment_name }}</option>
                                                    @endforeach
                                                </select>
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
                            <h3 class="box-title"><i class="fa fa-list-ul"></i>&nbsp; Base Patterns List</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-body no-padding">
                                <div id="basePatternReload">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Base Pattern</th>
                                        <th>Garment</th>
                                        <th>Actions</th>
                                    </tr>
                                    @foreach($basePatterns as $bsP)
                                    <tr>
                                        <td>{{ $bsP->base_pattern_id }}</td>
                                        <td>{{ $bsP->base_pattern }}</td>
                                        <td>{{ $bsP->garment_name }}</td>
                                        <td><i hint="tooltip" title="Edit" data-toggle="modal" data-target="#editBasePattern" class="fa fa-edit shop-action base-pattern-action-edit"
                                               data-basep-id="{{ $bsP->base_pattern_id }}"
                                               data-base-pattern="{{ $bsP->base_pattern }}"
                                               data-basep-garment="{{ $bsP->garment_id }}"></i>
                                            <i hint="tooltip" title="Delete" data-basep-id="{{ $bsP->base_pattern_id }}" data-toggle="modal" data-target="#deleteBasePattern" class="fa fa-trash-o shop-action base-pattern-action-delete"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->

    </section>
    <!-- /.content -->

@endsection

@section('modals')

    <div class="modal fade" id="editGarment">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit garment consumptions</h4>
                    </div>
                    <div class="modal-body">
                        <form id="changeGarmentData">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h4 id="mGarmentName" style="margin-top: 0px;padding-top: 0px">3 piece suit</h4>
                                <input id="modalGarmentId" type="hidden" name="gId" readonly>
                                <div class="form-group">
                                    <label for="mfabricConsumption">Fabric consumption</label>
                                    <input class="form-control" type="number" step="any" name="gFabric" id="mfabricConsumption">
                                </div>
                                <div id="imgHandling">
                                    <div class="form-group">
                                        <label for="mliningConsumption">Lining consumption</label>
                                        <input id="mliningConsumption" type="number" step="any" name="gLining" class="form-control" placeholder="Enter name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div id="changeGarment" class="btn btn-primary pull-left">Save changes</div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="editBaseSize">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Base Size</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <form id="changeBaseSizeData">
                                <input name="bsId" id="mBSId" type="hidden" readonly>
                                <div class="form-group">
                                    <label for="mBSize">Base size</label>
                                    <input name="bs" class="form-control" type="text" step="any" id="mBSize">
                                </div>
                                <div class="form-group">
                                    <label for="mBSGarment">Select garment</label>
                                    <select name="bsGarment" id="mBSGarment" class="form-control">
                                        @foreach($garments as $mgBS)
                                            <option value="{{ $mgBS->garment_id }}">{{ $mgBS->garment_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="changeBaseSize" class="btn btn-primary pull-left">Save changes</div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="deleteBaseSize">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Base Size</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete Base Size having ID : " <span id="baseSizeIdToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="confirmDeleteBS" class="btn btn-danger">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="editBasePattern">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Base Pattern</h4>
                    </div>
                    <div class="modal-body">
                        <form id="changeBasePatternData">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <input name="bpId" id="mBasePId" type="text" readonly>
                                <div class="form-group">
                                    <label for="mBPattern">Base Pattern</label>
                                    <input name="bp" class="form-control" type="text" step="any" id="mBPattern">
                                </div>
                                <div class="form-group">
                                    <label for="mBasePGarment">Select garment</label>
                                    <select name="bpGarment" id="mBasePGarment" class="form-control">
                                        @foreach($garments as $mgBP)
                                            <option value="{{ $mgBP->garment_id }}">{{ $mgBP->garment_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div id="changeBasePattern" class="btn btn-primary pull-left">Save changes</div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="deleteBasePattern">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Base Pattern</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete Base Pattern having ID : " <span id="basePatternIdToDelete"></span> " ?</p>
                </div>
                <div class="modal-footer">
                    <div id="confirmDeleteBP" class="btn btn-danger" onclick="window.location.href='#'">Yes</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection