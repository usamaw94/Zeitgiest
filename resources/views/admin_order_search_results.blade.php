@extends('layouts.customAdmin')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/users"><i class="fa fa-user"></i> <span>Manage Users</span></a></li>
        <li class="active"><a href="/adminOrders"><i class="fa fa-shopping-bag"></i> <span>View Orders</span></a></li>
    </ul>
@endsection

@section('content')

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
            View Orders
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="callout callout-info">
            <h4>Search results for</h4>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <p><b>{{ $searchBy }} : {{ $parameter }}</b></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Results</h3>
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
                            <td><i onclick="window.location.href='/adminViewOrder/{{ $o->o_id }}'" class="fa fa-eye order-action order-action-view" hint="tooltip" title="View Order"></i>
                                <i data-item-id="{{ $o->o_id }}" id="showTimeline" hint="tooltip" title="Processing Timeline" data-toggle="modal" data-target="#timeline" class="fa fa-history order-action order-action-timeline"></i>
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