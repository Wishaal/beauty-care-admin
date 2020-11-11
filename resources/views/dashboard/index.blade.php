@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <!-- /.content-header -->
    <div class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4>Clients Today {{$ordersCount}} | Total {{ $clients }}</h4>
                        <table class="table">
                            <tr>
                                <td>@if(!empty($todayrecords))  {{  $todayrecords->product_srd_total+$todayrecords->service_srd_total }} @endif </td>
                                <td>SRD</td>
                            </tr>
                            <tr>
                                <td>@if(!empty($todayrecords)) {{ $todayrecords->product_usd_total+$todayrecords->service_usd_total }} @endif </td>
                                <td>USD</td>
                            </tr>
                            <tr>
                                <td>@if(!empty($todayrecords)) {{ $todayrecords->product_eur_total+$todayrecords->service_eur_total }} @endif </td>
                                <td>EUR</td>
                            </tr>
                        </table>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                    <a href="{!! route('service-payments.index') !!}" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4>Products Today</h4>
                        <table class="table">
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords))  <b>{{ $todayrecords->product_srd_total }} @endif </b></td>
                                <td> @if(!empty($todayrecords)) Discount <b>{{ $todayrecords->discount_product_total_srd }} @endif </b></td>
                                <td><b>SRD</b></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords)) <b>{{ $todayrecords->product_usd_total }} @endif </b></td>
                                <td>@if(!empty($todayrecords)) Discount <b>{{ $todayrecords->discount_product_total_usd }} @endif </b></td>
                                <td><b>USD</b></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords)) <b>{{ $todayrecords->product_eur_total }} @endif </b></td>
                                <td>@if(!empty($todayrecords)) Discount <b>{{ $todayrecords->discount_product_total_eur }} @endif </b></td>
                                <td><b>EUR</b></td>
                            </tr>
                        </table>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="{!! route('service-payments.index') !!}" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>Services Today</h4>
                        <table class="table">
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords))  <b>{{ $todayrecords->service_srd_total }} @endif </b></td>
                                <td>@if(!empty($todayrecords))  Discount <b>{{ $todayrecords->discount_service_total_srd }} @endif </b></td>
                                <td><b>SRD</b></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords)) <b>{{ $todayrecords->service_usd_total }} @endif </b></td>
                                <td>@if(!empty($todayrecords)) Discount <b>{{ $todayrecords->discount_service_total_usd }} @endif </b> </td>
                                <td><b>USD</b></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>@if(!empty($todayrecords)) <b>{{ $todayrecords->service_eur_total }} @endif </b></td>
                                <td>@if(!empty($todayrecords)) Discount {{ $todayrecords->discount_service_total_eur }} @endif </td>
                                <td><b>EUR</b></td>
                            </tr>
                        </table>
                       </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="{!! route('service-payments.index') !!}" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
            <div><div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Services vs Products</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table responsive">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Services SRD</th>
                                <th>Services USD</th>
                                <th>Services EUR</th>
                                <th>Products</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>Last three months</td>
                                <td>{{$last3months->sum('service_srd_total')}} SRD</td>
                                <td>{{$last3months->sum('service_usd_total')}} USD</td>
                                <td>{{$last3months->sum('service_eur_total')}} EURO</td>
                                <td>{{$last3months->sum('product_srd_total')}} SRD</td>
                            </tr>
                            <tr>
                                <td>Last month</td>
                                <td>{{$lastmonth->sum('service_srd_total')}} SRD</td>
                                <td>{{$lastmonth->sum('service_usd_total')}} USD</td>
                                <td>{{$lastmonth->sum('service_eur_total')}} EURO</td>
                                <td>{{$lastmonth->sum('product_srd_total')}} SRD</td>
                            </tr>
                            <tr>
                                <td>This month</td>
                                <td>{{$thismonth->sum('service_srd_total')}} SRD</td>
                                <td>{{$thismonth->sum('service_usd_total')}} USD</td>
                                <td>{{$thismonth->sum('service_eur_total')}} EURO</td>
                                <td>{{$thismonth->sum('product_srd_total')}} SRD</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')

@endsection
@section('js')
    <script>
        Highcharts.chart('container', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Services last & this week'
            },
            xAxis: {
                categories: [@foreach ($chartpayment as $r)'{{date('d-m-Y', strtotime($r->created_at))}}',@endforeach]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total SRD'
                },
                stackLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Service SRD',
                data: [@foreach ($chartpayment as $r){{ $r->service_srd_total }},@endforeach],
                stack: 'service'
            }, {
                name: 'Service USD',
                data: [@foreach ($chartpayment as $r){{ $r->service_usd_total }},@endforeach],

                stack: 'service'
            },
                {
                    name: 'Service EURO',
                    data: [@foreach ($chartpayment as $r){{ $r->service_eur_total }},@endforeach],
                    stack: 'service'
                },
                {
                    name: 'Service Discount SRD',
                    data: [@foreach ($chartpayment as $r){{ $r->discount_service_total_srd }},@endforeach],
                    stack: 'service'
                },
                {
                    name: 'Service Discount USD',
                    data: [@foreach ($chartpayment as $r){{ $r->discount_service_total_usd }},@endforeach],
                    stack: 'service'
                },
                {
                    name: 'Service Discount EURO',
                    data: [@foreach ($chartpayment as $r){{ $r->discount_service_total_eur }},@endforeach],
                    stack: 'service'
                },
                {
                    name: 'Product SRD',
                    data: [@foreach ($chartpayment as $r){{ $r->product_srd_total }},@endforeach],
                    stack: 'product'
                },
                {
                    name: 'Product Discount SRD',
                    data: [@foreach ($chartpayment as $r){{ $r->discount_product_total_srd }},@endforeach],
                    stack: 'product'
                }]
        });


        $( document ).ready(function() {
            var host  = "<?php echo $_SERVER['SERVER_NAME']; ?>";
            toastr.info('Uploaded to SBC online');
            if(host =="sbc.com"){
                let _token   = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "/dashboard/upload",
                    type:"GET",
                    data:{
                        _token: _token
                    },
                    success:function(response){
                        if(response[0].status == "done"){
                            $.ajax({
                                url: "https://app.sunainasbeautycare.com/dashboard/import",
                                type:"GET",
                                success:function(data){
                                    toastr.info('Uploaded to SBC online');
                                },
                            });
                        }
                    },
                });
            }

        });
    </script>



@stop
@section('plugins.Chartjs', true)
