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
    <section class="content-header">
        <h1>
            List Mangement
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp; Lists</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>List Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($lists as $li)
                            <tr>
                                <td>{{ $li->li_id }}</td>
                                <td>{{ $li->li_name }}</td>
                                <td>{{ $li->img_status }}</td>
                                <td>
                                    <i hint="tooltip" title="Edit list litems" onclick="window.location.href='/listItems/{{ $li->li_id }}'" class="fa fa-edit list-action list-action-edit"></i>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection