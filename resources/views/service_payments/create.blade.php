@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    @can('currency-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('service-payments.index') !!}"><i
                                    class="fa fa-list mr-2"></i>Payments</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Create</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::open(['route' => 'service-payments.store','id' => 'myForm']) !!}
                <div class="row">
                    @include('service_payments.fields')
                </div>
                {!! Form::close() !!}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    @include('layouts.media_modal')
@endsection
@section('js')
    <script type="text/javascript">
        $('.clientselect').select2({ width: '100%', tags: true});
        function sumServices(){
            var srd = 0;
            var usd = 0;
            var eur = 0;
            $('.totalprice').each(function(){

                var bedrag = parseFloat(this.value);
                if(bedrag > 0){
                    if($(this).attr('data-currency') == 'SRD'){
                        srd += bedrag;
                    }

                    if($(this).attr('data-currency') == 'USD'){

                        usd += bedrag;
                    }

                    if($(this).attr('data-currency') == 'EURO'){
                        eur += bedrag;
                    }

                }
            });

            var srdDiscount = 0;
            var usdDiscount = 0;
            var eurDiscount = 0;
            $('.totalpricediscount').each(function(){
                var bedrag = parseFloat(this.value);
                if(bedrag > 0){
                    if($(this).attr('data-currency') == 'SRD'){
                        srdDiscount += bedrag;
                    }

                    if($(this).attr('data-currency') == 'USD'){
                        usdDiscount += bedrag;
                    }

                    if($(this).attr('data-currency') == 'EURO'){
                        eurDiscount += bedrag;
                    }
                }

            });

            var finalsrd = srd-srdDiscount;
            var finalusd = usd-usdDiscount;
            var finaleur = eur-eurDiscount;


            var html1 = '';
            var html2 = '';
            var html3 = '';

            if(finalsrd > 1){
                $('#totalsrd').val(finalsrd);
                html1='<tr><td>Totaal in SRD</td><td>'+finalsrd+'</td><td>Korting in SRD</td><td>'+srdDiscount+'</td></tr>';
            }

            if(finalusd > 1){
                $('#totalusd').val(finalusd);
                html2='<tr><td>Totaal in USD</td><td>'+finalusd+'</td><td>Korting in USD</td><td>'+usdDiscount+'</td></tr>';
            }

            if(finaleur > 1){
                $('#totaleur').val(finaleur);
                html3='<tr><td>Totaal in EURO</td><td>'+finaleur+'</td><td>Korting in EURO</td><td>'+eurDiscount+'</td></tr>';
            }

            $('.finaltotal').html('<table class="table table-bordered" id="dynamicTable">'+html1+html2+html3+'</table>');

        }

        $(document).on('keyup ', 'input[id^=pricediscount]', function () {
            if($(this).attr("data-currency") && $(this).attr("data-type")){
                var nameArr = $(this).attr('id').split('_');
                var type = $('#type_id_'+nameArr[1]).val();
                var currency = $('#currency_id_'+nameArr[1]).val();
                var price = $(this).val();

                $('#hiddendiscount_'+nameArr[1]).val(type+'-'+currency+'-'+price);

                sumServices();
            }else if(!$(this).attr("data-type")){
                alert('select type first');
                $(this).val('');
            }else{
                alert('select currency first');
                $(this).val('');
            }

        })

        $(document).on('change ', 'select[id^=type_id]', function () {
            var valueCurrency = $('option:selected', this).val();
            var nameArr = $(this).attr('id').split('_');
            $('#pricediscount_'+nameArr[2]).attr("data-type",valueCurrency);

            var type = $('#type_id_'+nameArr[2]).val();
            var currency = $('#currency_id_'+nameArr[2]).val();
            var price = $('#pricediscount_'+nameArr[2]).val();

            $('#hiddendiscount_'+nameArr[2]).val(type+'-'+currency+'-'+price);

            sumServices();

        }).keyup();

         $(document).on('change ', 'select[id=client_id]', function () {
                    var valueCurrency = $('option:selected', this).val();
                     if(Math.floor(valueCurrency) == valueCurrency && $.isNumeric(valueCurrency)){
                         $("#phonenumber").addClass("d-none");
                         $("#txtPhone").val("");
                     }else{
                         $("#phonenumber").removeClass("d-none");
                     }

                }).keyup();

        $(document).on('change ', 'select[id^=currency_id]', function () {
            var valueCurrency = $('option:selected', this).text();
            var nameArr = $(this).attr('id').split('_');
           $('#pricediscount_'+nameArr[2]).attr("data-currency",valueCurrency);

            var type = $('#type_id_'+nameArr[2]).val();
            var currency = $('#currency_id_'+nameArr[2]).val();
            var price = $('#pricediscount_'+nameArr[2]).val();

            $('#hiddendiscount_'+nameArr[2]).val(type+'-'+currency+'-'+price);


            sumServices();

        }).keyup();



        $(document).on('change ', 'select[id^=service_id]', function () {
            var value = $('option:selected', this).attr("data-priceInfo")
            var valueCurrency = $('option:selected', this).attr("data-priceCurrency")
            var nameArr = $(this).attr('id').split('_');

            $('#price_'+nameArr[2]).val(value+' '+valueCurrency);
            $('#price_'+nameArr[2]).attr("data-currency",valueCurrency);


            sumServices();

        }).keyup();


        $(document).on('change ', 'select[id^=product_id]', function () {
            var value = $('option:selected', this).attr("data-priceproductinfo")
            var valueCurrency = $('option:selected', this).attr("data-priceProductCurrency")
            var nameArr = $(this).attr('id').split('_');

            $('#price_product_'+nameArr[2]).val(value+' '+valueCurrency);
            $('#price_product_'+nameArr[2]).attr("data-currency",valueCurrency);

            sumServices();
        }).keyup();

        $('.xxx').select2();
        var i = 1;
        $("#add").click(function () {
            ++i;
            // Create clone of <div class='input-form'>
            $("#toClone:last").find('.xxx').select2('destroy');
            var newel = $('#toClone:last').clone();

            newel.find('#service_id_1').attr('id', 'service_id_' + i).attr('name', 'service_id[]');
            newel.find('#price_1').attr('id', 'price_' + i).attr('name', 'price[]').attr('value','0');

            // Add after last <div class='input-form'>
            $(newel).insertBefore("#beforeClone:last");
            $(newel).find('td:last').after('<td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>');

            $('.xxx').select2({width: '100%'});

            newel.find('#price_' + i).val(0);

            sumServices();


        });

        var i = 1;
        $("#addDiscount").click(function () {
            ++i;
            // Create clone of <div class='input-form'>
            $("#toCloneDiscount:last").find('.xxx').select2('destroy');
            var newel = $('#toCloneDiscount:last').clone();

            newel.find('#type_id_1').attr('id', 'type_id_' + i).attr('name', 'type_id[]');
            newel.find('#currency_id_1').attr('id', 'currency_id_' + i).attr('name', 'currency_id[]');
            newel.find('#pricediscount_1').attr('id', 'pricediscount_' + i).attr('name', 'pricediscount[]').attr('value','0');
            newel.find('#hiddendiscount_1').attr('id', 'hiddendiscount_' + i).attr('name', 'hiddendiscount[]').attr('value','');

            // Add after last <div class='input-form'>
            $(newel).insertBefore("#beforeCloneDiscount:last");
            $(newel).find('td:last').after('<td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>');

            $('.xxx').select2({width: '100%'});

            newel.find('#pricediscount_' + i).val(0);

            sumServices();


        });


        var iP = 1;
        $("#addProducts").click(function () {
            ++iP;
            // Create clone of <div class='input-form'>
            $("#toCloneProducts:last").find('.xxx').select2('destroy');
            var newel = $('#toCloneProducts:last').clone();

            newel.find('#product_id_1').attr('id', 'product_id_' + iP).attr('name', 'product_id[]');
            newel.find('#price_product_1').attr('id', 'price_product_' + iP).attr('name', 'price_product[]').attr('value','0');

            // Add after last <div class='input-form'>
            $(newel).insertBefore("#beforeCloneProducts:last");
            $(newel).find('td:last').after('<td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>');

            $('.xxx').select2({width: '100%'});

            newel.find('#price_product_' + iP).val(0);

            sumServices();


        });

        $(document).on('click', '.remove-tr', function () {

            $(this).parents('tr').remove();
            sumServices();

        });

    </script>
@stop

