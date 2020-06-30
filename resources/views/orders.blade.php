@extends('layouts.custom')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/shops"><i class="fa fa-building-o"></i> <span>Manage Shops</span></a></li>
        <li class="active" ><a href="/orders"><i class="fa fa-shopping-bag"></i> <span>Manage Orders</span></a></li>
        <li><a href="/lists"><i class="fa fa-list-alt"></i> <span>Manage Lists</span></a></li>
        <li><a href="/fabricLining"><i class="fa fa-link"></i> <span>Fabric & Lining</span></a></li>
        <li><a href="/garment"><i class="fa fa-link"></i> <span>Manage Garment</span></a></li>
    </ul>
    @endsection

@section('content')
        <div id="notify" class="box box-solid notify-panel">
            <p><i class="fa fa-check icon"></i>&nbsp;&nbsp;
                <span id="notifyText"></span>
            </p>
        </div>

        <div id="errorNotify" class="box box-solid error-notify-panel">
            <p><i class="fa fa-times icon"></i>&nbsp;&nbsp;
                <span id="errorNotifyText"></span>
            </p>
        </div>
            <!-- Content Header (Page header) -->
        <section class="content-header">

            @if (session('errorMsg'))
                <div id="staticErrorNotify" class="callout callout-danger">
                    <h4><i class="icon fa fa-times"></i>&nbsp;&nbsp;&nbsp;  {{ session('errorMsg') }}</h4>
                </div>
            @endif

            <h1>
                Order Management
            </h1>
        </section>

    <!-- Main content -->
        <section class="content container-fluid">

        <div class="panel box box-solid" style="background: #3c8dbc">
            <div style="color: white; cursor: pointer" class="box-header" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                <h4 class="box-title">
                    Search Orders
                </h4>
            </div>
            <div style="background-color: #fff; border-radius: 2px" id="collapseTwo" class="panel-collapse collapse">
                <div class="box-body">
                    <div class="col-md-offset-2 col-md-8">

                        <div class="box-body">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#advanceSearch" style="float: right">
                                <i class="fa fa-search"></i> &nbsp;&nbsp;Advance Search
                            </button>
                        </div>

                        <hr>

                        <div class="box-body">
                            <h4>Search by customer details</h4>
                            <form action="searchByCustomer" method="get">

                                <span class="help-block">Search customer by</span>
                                <div class="input-group my-group">
                                    <select class="form-control" name="searchBy">
                                        <option value="Customer Id">ID</option>
                                        <option value="Customer Name">Name</option>
                                        <option value="Customer Phone">Phone number</option>
                                        <option value="Customer Email">Email</option>
                                    </select>
                                    <input type="text" class="form-control" name="parameter" placeholder="Enter search parameter" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>
                            </form>
                        </div>

                        <hr>

                        <div class="box-body">
                            <h4>Search by order details</h4>
                            <form action="searchByOrder" method="get">

                                <span class="help-block">Search order by</span>
                                <div class="input-group my-group">
                                    <input type="text" class="form-control" value="Order Id" name="searchBy" readonly>
                                    <input type="text" class="form-control" name="parameter" placeholder="Enter search parameter">
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                                </div>
                            </form>

                            <form action="searchByOrder" method="get">

                                <div class="input-group my-group" style="margin-top: 10px">
                                    <input type="text" class="form-control" value="Item Type" name="searchBy" readonly>
                                    <select class="form-control pull-right" name="parameter">
                                        <option value="Suit" >Suit</option>
                                        <option value="Jacket" >Jacket</option>
                                        <option value="Pant" >Pant</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>

                            <form action="searchByOrder" method="get">

                                <div class="input-group my-group" style="margin-top: 10px">
                                    <input type="text" class="form-control" value="Order Type" name="searchBy" readonly>
                                    <select class="form-control pull-right" name="parameter">
                                        <option value="Be spoke" >Be spoke</option>
                                        <option value="MTM" >MTM</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>

                            <form action="searchByOrder" method="get">

                                <div class="input-group my-group" style="margin-top: 10px">
                                    <input type="text" class="form-control" value="Order Status" name="searchBy" readonly>
                                    <select class="form-control pull-right" name="parameter">
                                        <option value="pending review" >Pending Review</option>
                                            <option value="pre-production" >Pre-production</option>
                                            <option value="canceled" >Canceled</option>
                                            <option value="in warehouse" >In warehouse</option>
                                            <span class="label label-warehouse"></span>
                                            <option value="in store" >In store</option>
                                            <option value="sold" >Sold</option>
                                    </select>
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                                </div>
                            </form>

                            <form action="searchByOrder" method="get">

                                <div class="input-group my-group" style="margin-top: 10px">
                                    <select class="form-control" name="searchBy">
                                        <option value="Order Date" >Date Placed</option>
                                        <option value="Order Delivry Date" >Delivery Date</option>
                                    </select>
                                    <input type="text" class="form-control pull-right datepicker" name="parameter" placeholder="Enter search parameter">
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                                </div>
                            </form>
                        </div>

                        <hr>

                        <div class="box-body">
                            <h4>Search by shop</h4>
                            <form action="searchByShop" method="get">
                                <span class="help-block">Search by shop ID</span>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="parameter" required placeholder="Enter shop id">
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Order list</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    <div id="reload">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Order ID</th>
                            <th>Shop ID</th>
                            <th>Customer Name</th>
                            <th>Item Type</th>
                            <th>Order Type</th>
                            <th>Date</th>
                            <th>Delivery date</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($orders as $o)
                        <tr>
                            <td>{{ $o->o_id }}</td>
                            <td>{{ $o->s_id }}</td>
                            <td>{{ $o->c_name }}</td>
                            <td>{{ $o->item_type }}</td>
                            <td>{{ $o->order_type }}</td>
                            <td>{{ 	$o->o_date }}</td>
                            <td>{{ $o->delivery_date }}</td>
                            <td>{{ $o->o_price }}</td>
                            <td>
                                @if($o->o_status == 'Pending Review' )
                                    <span class="label label-warning">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'Pre-production' )
                                    <span class="label label-pre-production">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'Canceled' )
                                    <span class="label label-danger">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'In Production' )
                                    <span class="label label-production">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'In Warehouse' )
                                    <span class="label label-warehouse">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'In Store' )
                                    <span class="label label-store">{{ $o->o_status }}</span>
                                @elseif($o->o_status == 'Sold' )
                                    <span class="label label-success">{{ $o->o_status }}</span>
                                @endif
                            </td>
                            <td><i title="View Order" onclick="window.location.href='/viewOrder/{{ $o->o_id }}'" hint="tooltip" class="fa fa-eye order-action order-action-view"></i>
                                <i data-toggle="modal" hint="tooltip" title="Change Status" data-target="#changeStatus" class="fa fa-refresh order-action order-action-change"
                                   data-item-id="{{ $o->o_id }}"
                                   data-shop-id="{{ $o->s_id }}"
                                   data-c-name="{{ $o->c_name }}"
                                   data-order-type="{{ $o->item_type }}"
                                   data-o-date="{{ $o->o_date }}"
                                   data-d-date="{{ $o->delivery_date }}"
                                   data-status="{{ $o->o_status }}"
                                   data-fabric-id="{{ $o->o_fabric }}"
                                   data-lining-id="{{ $o->o_lining }}">
                                </i>
                                <i data-toggle="modal" id="showTimeline" data-item-id="{{ $o->o_id }}" data-target="#timeline" hint="tooltip" title="Processing Timeline" class="fa fa-history order-action order-action-timeline"></i>
                                <i data-toggle="modal" data-target="#viewCustomer" hint="tooltip" title="View Customer" class="fa fa-user order-action order-action-customer"
                                   data-customer-id ="{{ $o->c_id }}"
                                   data-customer-name ="{{ $o->c_name }}"
                                   data-customer-p-phone ="{{ $o->p_phone }}"
                                   data-customer-s-phone ="{{ $o->s_phone }}"
                                   data-customer-email ="{{ $o->c_email }}"
                                   data-customer-city ="{{ $o->c_city }}"
                                   data-customer-address ="{{ $o->c_address }}">
                                </i>
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
    <div class="modal fade" id="changeStatus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-status-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change status</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" style="margin-bottom: 0px">
                        <tr>
                            <th>Order ID</th>
                            <td id="mOId"></td>
                        </tr>
                        <tr>
                            <th>Shop Id</th>
                            <td id="mSId"></td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td id="mCName"></td>
                        </tr>
                        <tr>
                            <th>Order Type</th>
                            <td id="mOType"></td>
                        </tr>
                        <tr>
                            <th>Placed on</th>
                            <td id="mODate"></td>
                        </tr>
                        <tr>
                            <th>Delivered on</th>
                            <td id="mDDate"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span id="mStatus" class="label"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <form id="changeStatusData">
                        <h5 class="no-space" style="text-align: left; margin-bottom: 10px;font-weight: bold">Assign New Status</h5>
                        <input type="hidden" name="prevStatus" id="prevStatus">
                        <input type="hidden" name="fabric" id="fabric">
                        <input type="hidden" name="lining" id="lining">
                        <input type="hidden" name="itemType" id="itemType">
                        <input type="hidden" name="orderId" id="orderID">
                        <select id="selectBox" name="status" style="margin-bottom: 10px" class="form-control"></select>
                        <h5 class="no-space" style="text-align: left; margin-bottom: 10px;font-weight: bold">Enter password</h5>
                        <input id="pass" required style="margin-bottom: 10px" class="form-control" type="password" name="password" placeholder="Enter admin password to change status">
                    </form>
                        <div id="submitStatusData" class="btn btn-primary">Submit</div>
                        <button type="button" class="btn btn-default close-status-modal" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="timeline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Order processing timeline</h4>
                </div>
                <div class="modal-body" style="background: #ecf0f5">
                <ul class="timeline" id="timeLineContainer">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="advanceSearch">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="advanceSearch" method="get">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Advance search</h4>
                </div>
                <div class="modal-body">
                    <h6 class="no-space" style="text-align: left;font-weight: bold">Customer Id</h6>
                    <input type="text" class="form-control" name="cId">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Customer Name</h6>
                    <input type="text" class="form-control" name="cName">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Customer Phone Number</h6>
                    <input type="text" class="form-control" name="cPhone">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Customer Email</h6>
                    <input type="text" class="form-control" name="cEmail">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Order Id</h6>
                    <input type="text" class="form-control" name="oId">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Order Item Type</h6>
                    <select style="margin-bottom: 10px" name="oIType" class="form-control">
                        <option value="" >Select item type</option>
                        <option value="Suit" >Suit</option>
                        <option value="Jacket" >Jacket</option>
                        <option value="Pant" >Pant</option>
                    </select>
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Order Type</h6>
                    <select style="margin-bottom: 10px" name="oType" class="form-control">
                        <option value="" >Select item type</option>
                        <option value="Be spoke" >Be spoke</option>
                        <option value="MTM" >MTM</option>
                    </select>
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Order Status</h6>
                    <select style="margin-bottom: 10px" name="oStatus" class="form-control">
                        <option value="" >Select status</option>
                        <option value="Pending Review" >Pending Review</option>
                        <option value="Pre-production" >Accepted - Pre production</option>
                        <option value="Canceled" >Canceled</option>
                        <option value="In production" >In production</option>
                        <option value="In production" >In production</option>
                        <option value="In store" >In store</option>
                    </select>
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Date Placed</h6>
                    <input type="text" class="form-control datepicker" name="oDate">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Delivery Date</h6>
                    <input type="text" class="form-control datepicker" name="oDelivery">
                    <h6 class="no-space" style="text-align: left;font-weight: bold;margin-top: 10px">Shop Id</h6>
                    <input type="text" class="form-control" name="sId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="viewCustomer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-status-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Customer Info</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" style="margin-bottom: 0px">
                        <tr>
                            <th>Customer ID</th>
                            <td id="cIdM"></td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td id="cNameM"></td>
                        </tr>
                        <tr>
                            <th>Primary Phone</th>
                            <td id="cPPhoneM"></td>
                        </tr>
                        <tr>
                            <th>Secondary Phone</th>
                            <td id="cSPhoneM"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="cEmailM"></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td id="cCityM"></td>
                        </tr>
                        <tr>
                            <th>Complete Address</th>
                            <td id="cAddressM"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('script')

    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        })
    </script>

    @endsection