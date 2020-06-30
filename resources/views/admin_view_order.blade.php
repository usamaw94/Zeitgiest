@extends('layouts.customAdmin')

@section('sideContent')
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="/users"><i class="fa fa-user"></i> <span>Manage Users</span></a></li>
        <li class="active"><a href="/adminOrders"><i class="fa fa-shopping-bag"></i> <span>View Orders</span></a></li>
    </ul>
@endsection

@section('content')
    <div id="notify" class="box box-solid notify-panel">
        <p><i class="fa fa-check icon"></i>&nbsp;&nbsp;
            <span>Notification</span>
        </p>
    </div>
    <!-- Content Header (Page header) -->
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

        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#tab_1-1" data-toggle="tab"><b>Basic Info.</b></a></li>
            <li><a href="#tab_2-2" data-toggle="tab"><b>Measurements</b></a></li>
            <li><a href="#tab_3-3" data-toggle="tab"><b>Stylings</b></a></li>
            <li><a href="#tab_4-4" data-toggle="tab"><b>Customer Feedback</b></a></li>
        </ul>

            <div class="tab-content" style="padding-top: 20px">
                <div class="tab-pane active" id="tab_1-1">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Order Info</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th>Order Id</th>
                        <td>{{ $orderDetail[0]->o_id }}</td>
                    </tr>
                    <tr>
                        <th>Customer Id</th>
                        <td>{{ $orderDetail[0]->c_id }}</td>
                    </tr>
                    <tr>
                        <th>Customer name</th>
                        <td>{{ $orderDetail[0]->c_name }}</td>
                    </tr>
                    <tr>
                        <th>Order date</th>
                        <td>{{ $orderDetail[0]->o_date }}</td>
                    </tr>
                    <tr>
                        <th>Shop Id</th>
                        <td>{{ $orderDetail[0]->s_id }}</td>
                    </tr>
                    <tr>
                        <th>Order type</th>
                        <td>{{ $orderDetail[0]->order_type }}</td>
                    </tr>
                    <tr>
                        <th>Item type</th>
                        <td>{{ $orderDetail[0]->item_type }}</td>
                    </tr>
                    <tr>
                        <th>Delivery date</th>
                        <td>{{ $orderDetail[0]->delivery_date }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $orderDetail[0]->o_price }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($orderDetail[0]->o_status == 'Pending Review' )
                                <span class="label label-warning">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'Pre-production' )
                                <span class="label label-pre-production">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'Canceled' )
                                <span class="label label-danger">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'In Production' )
                                <span class="label label-production">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'In Warehouse' )
                                <span class="label label-warehouse">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'In Store' )
                                <span class="label label-store">{{ $orderDetail[0]->o_status }}</span>
                            @elseif($orderDetail[0]->o_status == 'Sold' )
                                <span class="label label-success">{{ $orderDetail[0]->o_status }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <button data-toggle="modal" data-target="#viewCustomer" type="button" class="btn btn-primary">
                                <i class="fa fa-user"></i> &nbsp;
                                View Customer Details
                            </button>
                            <button data-toggle="modal" data-target="#timeline" type="button" class="btn btn-primary">
                                <i class="fa fa-history"></i> &nbsp;
                                View order processing timeline
                            </button>
                        </th>
                        <td></td>
                    </tr>
                </table>
                <div class="container-fluid">
                    <div class="row">
                        <h4>Customer Photos</h4>
                        @if($orderDetail[0]->photo_1 != null || $orderDetail[0]->photo_1 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_1 }}" data-img-src="{{ $orderDetail[0]->photo_1 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_2 != null || $orderDetail[0]->photo_2 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_2 }}" data-img-src="{{ $orderDetail[0]->photo_2 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_3 != null || $orderDetail[0]->photo_3 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_3 }}" data-img-src="{{ $orderDetail[0]->photo_3 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_4 != null || $orderDetail[0]->photo_4 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_4 }}" data-img-src="{{ $orderDetail[0]->photo_4 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_5 != null || $orderDetail[0]->photo_5 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_5 }}" data-img-src="{{ $orderDetail[0]->photo_5 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_6 != null || $orderDetail[0]->photo_6 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_6 }}" data-img-src="{{ $orderDetail[0]->photo_6 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_7 != null || $orderDetail[0]->photo_7 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_7 }}" data-img-src="{{ $orderDetail[0]->photo_7 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_8 != null || $orderDetail[0]->photo_8 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_8 }}" data-img-src="{{ $orderDetail[0]->photo_8 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_9 != null || $orderDetail[0]->photo_9 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_9 }}" data-img-src="{{ $orderDetail[0]->photo_9 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                        @if($orderDetail[0]->photo_10 != null || $orderDetail[0]->photo_10 != '')
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <img src="{{ $orderDetail[0]->photo_10 }}" data-img-src="{{ $orderDetail[0]->photo_10 }}" data-toggle="modal" data-target="#viewCustomerPhoto" class="img-thumbnail customer-photo">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
                    </div>

                <div class="tab-pane" id="tab_2-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Measurement Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if($measurementData != 'empty')
                    <div class="box-body no-padding">
                    <h4>Body Description</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Stance</b>
                                    </h5>
                                </div>
                                <img src="{{ $measurementDetail[0]->stance_img }}" style="width:100%">
                                <div class="caption">
                                    <p class="no-space">
                                        {{ $measurementDetail[0]->stance }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Shoulder slope</b>
                                    </h5>
                                </div>
                                <img src="{{ $measurementDetail[0]->shoulder_img }}" style="width:100%">
                                <div class="caption">
                                    <p class="no-space">
                                        {{ $measurementDetail[0]->shoulder }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Chest</b>
                                    </h5>
                                </div>
                                <img src="{{ $measurementDetail[0]->chest_img }}" style="width:100%">
                                <div class="caption">
                                    <p class="no-space">
                                        {{ $measurementDetail[0]->chest }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Stomach</b>
                                    </h5>
                                </div>
                                <img src="{{ $measurementDetail[0]->stomach_img }}" style="width:100%">
                                <div class="caption">
                                    <p class="no-space">
                                        {{ $measurementDetail[0]->stomach }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Hip</b>
                                    </h5>
                                </div>
                                <img src="{{ $measurementDetail[0]->hip_img }}" style="width:100%">
                                <div class="caption">
                                    <p class="no-space">
                                        {{ $measurementDetail[0]->hip }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 style="font-size: 20px">Measurements</h4>
                </div>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Neck</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->neck }}</td>
                        </tr>
                        <tr>
                            <th>Full Chest</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->full_chest }}</td>
                        </tr>
                        <tr>
                            <th>Full shoulder width</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->shoulder_width }}</td>
                        </tr>
                        <tr>
                            <th>Right sleeve</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->right_sleeve }}</td>
                        </tr>
                        <tr>
                            <th>Left sleeve</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->left_sleeve }}</td>
                        </tr>
                        <tr>
                            <th>Bicep</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->bicep }}</td>
                        </tr>
                        <tr>
                            <th>Wrist</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->wrist }}</td>
                        </tr>
                        <tr>
                            <th>Waist stomach</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->waist_stomach }}</td>
                        </tr>
                        <tr>
                            <th>Hip</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->hip_m }}</td>
                        </tr>
                        <tr>
                            <th>Front jacket length</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->front_jacket_length }}</td>
                        </tr>
                        <tr>
                            <th>Front chest width</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->front_chest_width }}</td>
                        </tr>
                        <tr>
                            <th>Back width</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->back_width }}</td>
                        </tr>
                        <tr>
                            <th>Half shoulder width(left)</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->half_shoulder_width_left }}</td>
                        </tr>
                        <tr>
                            <th>Half shoulder width(right)</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->half_shoulder_width_right }}</td>
                        </tr>
                        <tr>
                            <th>Full back legth</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->full_back_length }}</td>
                        </tr>
                        <tr>
                            <th>Half back length</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->half_back_length }}</td>
                        </tr>
                        <tr>
                            <th>Trouser waist</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->trouser_waist }}</td>
                        </tr>
                        <tr>
                            <th>Trouser outseam</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->trouser_outseam }}</td>
                        </tr>
                        <tr>
                            <th>Trouser inseam</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->trouser_inseam }}</td>
                        </tr>
                        <tr>
                            <th>Crotch</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->crotch }}</td>
                        </tr>
                        <tr>
                            <th>Thigh</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->thigh }}</td>
                        </tr>
                        <tr>
                            <th>Knee</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->knee }}</td>
                        </tr>
                        <tr>
                            <th>Right full sleeve</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->right_full_sleeve }}</td>
                        </tr>
                        <tr>
                            <th>Left full sleeve</th>
                            <td><img class="measurement-img" src="coat%20image.jpg"></td>
                            <td>{{ $measurementDetail[0]->left_full_sleeve }}</td>
                        </tr>
                    </table>
                @else
                    <h4>No data to show</h4>
                @endif
            </div>

        </div>
        <!-- /.box -->
                    </div>

                <div class="tab-pane" id="tab_3-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Styling Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            @if($stylingData != 'empty')
                <div class="box-body">
                <div class="box-body no-padding">
                    <div class="row styling-container">
                        @if($fabric[0]->itm_num != null && $fabric[0]->itm_num != '')
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <h5 class="no-space">
                                            <b>Fabric</b>
                                        </h5>
                                    </div>
                                    <img src="{{ $fabric[0]->itm_img_src }}" class="thumb-img">
                                    <div class="caption b-content">
                                        <p class="no-space">
                                            {{ $fabric[0]->itm_num }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($lining[0]->itm_num != null && $lining[0]->itm_num != '')
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <h5 class="no-space">
                                            <b>Lining</b>
                                        </h5>
                                    </div>
                                    <img src="{{ $lining[0]->itm_img_src }}" class="thumb-img">
                                    <div class="caption b-content">
                                        <p class="no-space">
                                            {{ $lining[0]->itm_num }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($stylingDetail[0]->fitting != null && $stylingDetail[0]->fitting != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Fitting</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->fitting_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->fitting }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->jacket_style != null && $stylingDetail[0]->jacket_style != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Jacket style</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->jacket_style_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->jacket_style }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->front_panel_roundness != null && $stylingDetail[0]->front_panel_roundness != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Front Panel Roundness</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->front_panel_roundness_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->front_panel_roundness }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->jacket_length != null && $stylingDetail[0]->jacket_length != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Jacket length</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->jacket_length_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->jacket_length }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->lapel_style != null && $stylingDetail[0]->lapel_style != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Lapel style</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->lapel_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->lapel_style }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->lapel_curvature != null && $stylingDetail[0]->lapel_curvature != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Lapel curvature</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->lapel_curvature_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->lapel_curvature }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->lapel_pick_stitch != null && $stylingDetail[0]->lapel_pick_stitch != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Lapel pick stitch</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->lapel_pick_stich_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->lapel_pick_stitch }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->shoulder_construction != null && $stylingDetail[0]->shoulder_construction != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Shoulder construction</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->shoulder_construction_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->shoulder_construction }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->vent_style != null && $stylingDetail[0]->vent_style != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Vent</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->vent_style_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->vent_style }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->breast_pocket != null && $stylingDetail[0]->breast_pocket != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Breast pocket</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->breast_pocket_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->breast_pocket }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->side_pocket != null && $stylingDetail[0]->side_pocket != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Side pocket</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->side_pocket_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->side_pocket }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->ticket_pocket != null && $stylingDetail[0]->ticket_pocket != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Ticket pocket</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->ticket_pocket_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->ticket_pocket }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->cuff_button != null && $stylingDetail[0]->cuff_button != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Cuff button</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->cuff_button_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->cuff_button }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->functional_cuff != null && $stylingDetail[0]->functional_cuff != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Functional cuff</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->functional_cuff_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->functional_cuff }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->trouser_pleat != null && $stylingDetail[0]->trouser_pleat != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Trouser pleat</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->trouser_pleat_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->trouser_pleat }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->trouser_back_pocket != null && $stylingDetail[0]->trouser_back_pocket != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Trouser back pocket</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->trouser_back_pocket_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->trouser_back_pocket }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->trouser_cuff != null && $stylingDetail[0]->trouser_cuff != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Trouser cuff</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->trouser_cuff_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->trouser_cuff }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->trouser_loop_tab != null && $stylingDetail[0]->trouser_loop_tab != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Trouser loop tab</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->trouser_loop_tab_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->trouser_loop_tab }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->waist_coat_type != null && $stylingDetail[0]->waist_coat_type != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Waist coat type</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->waist_coat_type_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->waist_coat_type }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->waist_coat_pocket_type != null && $stylingDetail[0]->waist_coat_pocket_type != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Waist coat pocket type</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->waist_coat_pocket_type_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->waist_coat_pocket_type }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($stylingDetail[0]->back != null && $stylingDetail[0]->back != '')
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h5 class="no-space">
                                        <b>Back</b>
                                    </h5>
                                </div>
                                <img src="{{ $stylingDetail[0]->back_img }}" class="thumb-img">
                                <div class="caption b-content">
                                    <p class="no-space">
                                        {{ $stylingDetail[0]->back }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                            @if($stylingDetail[0]->buttons != null && $stylingDetail[0]->buttons != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Buttons</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->buttons_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->buttons }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($stylingDetail[0]->lapel_eyelet_color != null && $stylingDetail[0]->lapel_eyelet_color != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Lapel eyelet color</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->lapel_eyelet_color_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->lapel_eyelet_color }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($stylingDetail[0]->cuff_eyelet_color != null && $stylingDetail[0]->cuff_eyelet_color != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Cuff eyelet color</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->cuff_eyelet_color_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->cuff_eyelet_color }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($stylingDetail[0]->piping_color != null && $stylingDetail[0]->piping_color != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Piping color</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->piping_color_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->piping_color }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($stylingDetail[0]->melton_undercollar_num != null && $stylingDetail[0]->melton_undercollar_num != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Melton undercollar number</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->melton_undercollar_num_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->melton_undercollar_num }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($stylingDetail[0]->shoulder_pads != null && $stylingDetail[0]->shoulder_pads != '')
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <div class="caption">
                                            <h5 class="no-space">
                                                <b>Shoulder Pads</b>
                                            </h5>
                                        </div>
                                        <img src="{{ $stylingDetail[0]->shoulder_pads_img }}" class="thumb-img">
                                        <div class="caption b-content">
                                            <p class="no-space">
                                                {{ $stylingDetail[0]->shoulder_pads }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
            @else
                <div class="box-body">
                    <div class="box-body no-padding">
                        <h4>No data to show</h4>
                    </div>
                </div>
            @endif
        </div>
        <!-- /.box -->
                    </div>
                <div class="tab-pane" id="tab_4-4">
                    <div class="box box-solid">
                        <div class="box-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Measurement Giving Experience</th>
                                    <td>{{ $feedback[0]->answer_1 }}</td>
                                </tr>
                                <tr>
                                    <th>Quality of Sales Staff</th>
                                    <td>{{ $feedback[0]->answer_2 }}</td>
                                </tr>
                                <tr>
                                    <th>Fabric Options</th>
                                    <td>{{ $feedback[0]->answer_3 }}</td>
                                </tr>
                                <tr>
                                    <th>Customizable Options</th>
                                    <td>{{ $feedback[0]->answer_4 }}</td>
                                </tr>
                                <tr>
                                    <th>Speed of Delivery</th>
                                    <td>{{ $feedback[0]->answer_5 }}</td>
                                </tr>
                                <tr>
                                    <th>Quality of Stitching</th>
                                    <td>{{ $feedback[0]->answer_6 }}</td>
                                </tr>
                                <tr>
                                    <th>Quality of Fitting</th>
                                    <td>{{ $feedback[0]->answer_7 }}</td>
                                </tr>
                                <tr>
                                    <th>Overall Quality of Final Product</th>
                                    <td>{{ $feedback[0]->answer_8 }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <h4>Customer's Info</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $feedback[0]->o_id }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Id</th>
                                    <td>{{ $feedback[0]->c_id }}</td>
                                </tr>
                                <tr>
                                    <th>Order Number</th>
                                    <td>{{ $feedback[0]->cus_name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('modals')

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
                            <td>{{ $orderDetail[0]->c_id }}</td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td>{{ $orderDetail[0]->c_name }}</td>
                        </tr>
                        <tr>
                            <th>Primary Phone</th>
                            <td>{{ $orderDetail[0]->p_phone }}</td>
                        </tr>
                        <tr>
                            <th>Secondary Phone</th>
                            <td>{{ $orderDetail[0]->s_phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $orderDetail[0]->c_email }}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $orderDetail[0]->c_city }}</td>
                        </tr>
                        <tr>
                            <th>Complete Address</th>
                            <td>{{ $orderDetail[0]->c_address }}</td>
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

    <div class="modal fade" id="viewCustomerPhoto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-status-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Customer Photo</h4>
                </div>
                <div class="modal-body">
                    <img class="img-responsive" id="enlargePhoto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="timeline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Order processing timeline</h4>
                </div>
                <div class="modal-body" style="background: #ecf0f5">
                    <ul class="timeline">
                        <!-- timeline item -->
                        @foreach($timeline as $t)
                        <li>
                            <!-- timeline icon -->
                            <i class="fa fa-calendar bg-blue"></i>
                            <div class="timeline-item">

                                <h3 class="timeline-header">{{ $t->status }}</h3>

                                <div class="timeline-body">
                                    Date : <b>{{ $t->change_date }}</b><br>
                                    Updated By(Name) : <b>{{ $t->user_name }}</b><br>
                                    Email : <b>{{ $t->user_email }}</b>
                                </div>
                            </div>
                        </li>
                        @endforeach

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
    <!-- /.modal -->
@endsection