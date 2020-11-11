<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        {!! Form::label('name', 'Name', ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  'Name']) !!}
            <div class="form-text text-muted">
            </div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('name', 'Price', ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('price', null,  ['class' => 'form-control','placeholder'=>  'Price']) !!}
            <div class="form-text text-muted">
            </div>
        </div>
    </div>
    <!-- Category Id Field -->
    <div class="form-group row ">
        {!! Form::label('currency_id', "Currency",['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('currency_id', $currency, null, ['class' => 'select2 form-control']) !!}
        </div>
    </div>
    <!-- Category Id Field -->
    <div class="form-group row ">
        {!! Form::label('type_id', "Type",['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('type_id', $type, null, ['class' => 'select2 form-control']) !!}
        </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Product</button>
    <a href="{!! route('products.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
</div>
