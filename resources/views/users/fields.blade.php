<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name Field -->
<div class="form-group row ">
  {!! Form::label('name', 'Currency', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('currency', null,  ['class' => 'form-control','placeholder'=>  'SRD']) !!}
    <div class="form-text text-muted">

    </div>
  </div>
</div>
</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i> Save Currency</button>
  <a href="{!! route('currencies.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
</div>
