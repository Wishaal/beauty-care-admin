@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <!-- Content Header (Page header) -->
    @include('flash-message')
    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    @can('currency-list')
                        <li class="nav-item">
                            <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Today Payments</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('service-payments.create') !!}"><i class="fa fa-plus mr-2"></i>Create</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="users-table" class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Id</th>
                    </tr>
                    </thead>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@section('js')
    <script type="text/javascript">
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'http://sowi.sr/basic-data',
            columns: [
                {data: 'id', name: 'id'},
            ]
        });
    </script>
@stop
