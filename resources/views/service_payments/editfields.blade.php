<div class="col-lg-6">

    <div class="form-group row ">
        {!! Form::label('client_id', "Client",['class' => ' col-3 control-label text-left']) !!}
        <div class="col-9">
            {!! Form::select('client_id', $client, null, ['class' => 'clientselect select2 form-control']) !!}
        </div>
    </div>

    <div class="form-group row ">
        <table class="table table-bordered" id="dynamicTable">
            <tr>

                <th colspan="4">Discounts</th>

            </tr>
            @if (!empty($servicePayment->orderDiscounts[0]))
            <?php $count = 1;?>
            @foreach ($servicePayment->orderDiscounts as $r)
                <tr id='toCloneDiscount'>

                    <td>{!! Form::select('type_id[]', $type, $r->type, ['id'=>'type_id_'.$count,'class' => 'xxx select2 form-control', 'placeholder' => 'Select type']) !!}</td>
                    <td>{!! Form::select('currency_id[]', $currency, $r->currency_id, ['id'=>'currency_id_'.$count,'class' => 'xxx select2 form-control', 'placeholder' => 'Select currency']) !!}</td>
                    <input type="hidden" id="hiddendiscount_{{ $count }}" name="hiddendiscount[]" value="{{$r->type.'-'.$r->currency_id.'-'.$r->discount}}">
                    <td>   {!! Form::text('pricediscount[]', $r->discount,  ['id'=>'pricediscount_'.$count,'data-type'=>$r->type,'data-currency'=>$r->getcurrency->currency,'class' => 'form-control service totalpricediscount','placeholder'=>  'Price']) !!} </td>
                    <td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>
                </tr>
                    <?php $count++;?>
                @endforeach
            @else
                <tr id='toCloneDiscount'>

                <td>{!! Form::select('type_id[]', $type, null, ['id'=>'type_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select type']) !!}</td>
                <td>{!! Form::select('currency_id[]', $currency, null, ['id'=>'currency_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select currency']) !!}</td>
                <input type="hidden" id="hiddendiscount_1" name="hiddendiscount[]" value="">
                <td>   {!! Form::text('pricediscount[]', null,  ['id'=>'pricediscount_1','data-type'=>'','data-currency'=>'','class' => 'form-control service totalpricediscount','placeholder'=>  'Price']) !!} </td>
            </tr>
            @endif
            <tr id="beforeCloneDiscount">

                <td colspan="4">
                    <button type="button" name="addDiscount" id="addDiscount" class="btn btn-success">Add More Discount</button>
                </td>

            </tr>
        </table>
    </div>
    <div class="form-group row finaltotal"></div>
</div>
<div class="col-lg-6">
    <table class="table table-bordered" id="dynamicTable">

        <tr>

            <th colspan="3">Services</th>

        </tr>
        @if (!empty($servicePayment->servicePayments[0]))
            <?php $count = 1;?>
            @foreach ($servicePayment->servicePayments as $r)
                <tr id='toClone'>
                    <td>{!! Form::select('service_id[]', $service, $r->service_id, ['id'=>'service_id_'.$count,'class' => 'xxx select2 form-control', 'placeholder' => 'Select service'], $serviceprice) !!}</td>
                    <td>   {!! Form::text('price[]', $r->service->price.' '.$r->service->currency->currency,  ['data-currency'=> $r->service->currency->currency,'id'=>'price_'.$count,'readonly'=>'true','class' => 'form-control service totalprice','placeholder'=>  'Price']) !!} </td>
                    <td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>
                </tr>

            @endforeach
        @else
            <tr id='toClone'>
                <td>{!! Form::select('service_id[]', $service, null, ['id'=>'service_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select service'], $serviceprice) !!}</td>
                <td>   {!! Form::text('price[]', null,  ['id'=>'price_1','data-currency'=>'','readonly'=>'true','class' => 'form-control service totalprice','placeholder'=>  'Price']) !!} </td>
            </tr>
        @endif

        <tr id="beforeClone">

            <td colspan="3">
                <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
            </td>

        </tr>
    </table>

    <table class="table table-bordered" id="dynamicTable">

        <tr>

            <th colspan="3">Products</th>

        </tr>
        @if (!empty($servicePayment->orderPayments[0]))
            <?php $count = 1;?>
            @foreach ($servicePayment->orderPayments as $r)
                <tr id='toCloneProducts'>

                    <td>{!! Form::select('product_id[]', $product, $r->product_id, ['id'=>'product_id_'.$count,'class' => 'xxx form-control', 'placeholder' => 'Select product'], $productprice) !!}</td>

                    <td>   {!! Form::text('price_product[]', $r->product->price.' '.$r->product->currency->currency,  ['id'=>'price_product_'.$count,'data-currency'=>$r->product->currency->currency,'readonly'=>'true','class' => 'form-control product totalprice','placeholder'=>  'Price']) !!} </td>
                    <td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>
                </tr>
                <?php $count++;?>
            @endforeach
        @else
            <tr id='toCloneProducts'>

                <td>{!! Form::select('product_id[]', $product, null, ['id'=>'product_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select product'], $productprice) !!}</td>

                <td>   {!! Form::text('price_product[]', null,  ['id'=>'price_product_1','data-currency'=>'','readonly'=>'true','class' => 'form-control product totalprice','placeholder'=>  'Price']) !!} </td>
            </tr>
        @endif
        <tr id="beforeCloneProducts">

            <td colspan="3">
                <button type="button" name="addProducts" id="addProducts" class="btn btn-success">Add More</button>
            </td>

        </tr>
    </table>
</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <input type="hidden" id="totalsrd" name="totalsrd" value="0">
    <input type="hidden" id="totalusd" name="totalusd" value="0">
    <input type="hidden" id="totaleur" name="totaleur" value="0">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Payment</button>
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
</div>
