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
                            <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Vouchers</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('vouchers.create') !!}"><i class="fa fa-plus mr-2"></i>Create</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class=" table yajra-datatable">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>#</th>
                            <th>Voucher</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/vouchers",
                order: [[ 1, 'desc' ]],
                columns: [
                    {data: 'action', name: 'action', orderable: false, searchable: true},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'voucher', name: 'Voucher'},
                    {data: 'amount', name: 'Amount'},
                    {data: 'status', name: 'Status'},
                    {data: 'created_at', name: 'date'},
                ]
            });

        });
    </script>
@stop
