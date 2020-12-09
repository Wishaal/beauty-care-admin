<div class="col-lg-6">
    <div class="form-group row ">
        {!! Form::label('client_id', "Client",['class' => ' col-6 control-label text-left']) !!}
        <div class="col-6">
            {!! Form::select('client_id', $client, null, ['class' => 'clientselect select2 form-control']) !!}
        </div>
    </div>
    <div id='phonenumber' class="form-group row d-none">
        <label for="txtTitle" class="col-6 control-label text-left">Number:</label>
        <div class="col-6">
            <input type="text" name="txtPhone" class="form-control"
                   id="txtPhone" value="597"></div>
    </div>
    <div class="form-group row ">
        <table class="table table-bordered" id="dynamicTable">

            <tr>

                <th colspan="3">Discounts</th>

            </tr>
            <tr id='toCloneDiscount'>

                <td>{!! Form::select('type_id[]', $type, null, ['id'=>'type_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select type']) !!}</td>
                <td>{!! Form::select('currency_id[]', $currency, null, ['id'=>'currency_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select currency']) !!}</td>
                <input type="hidden" id="hiddendiscount_1" name="hiddendiscount[]" value="">
                <td>   {!! Form::text('pricediscount[]', null,  ['id'=>'pricediscount_1','data-type'=>'','data-currency'=>'','class' => 'form-control service totalpricediscount','placeholder'=>  'Price']) !!} </td>
            </tr>
            <tr id="beforeCloneDiscount">

                <td colspan="3">
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
        <tr id='toClone'>

            <td>{!! Form::select('service_id[]', $service, null, ['id'=>'service_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select service'], $serviceprice) !!}</td>

            <td>   {!! Form::text('price[]', null,  ['id'=>'price_1','data-currency'=>'','readonly'=>'true','class' => 'form-control service totalprice','placeholder'=>  'Price']) !!} </td>
        </tr>
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
        <tr id='toCloneProducts' class="remove-tr">

            <td>{!! Form::select('product_id[]', $product, null, ['id'=>'product_id_1','class' => 'xxx select2 form-control', 'placeholder' => 'Select product'], $productprice) !!}</td>

            <td>   {!! Form::text('price_product[]', null,  ['id'=>'price_product_1','data-currency'=>'','readonly'=>'true','class' => 'form-control product totalprice','placeholder'=>  'Price']) !!} </td>

        </tr>
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
