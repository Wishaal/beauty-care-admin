<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

    <div class="form-group row ">
        {!! Form::label('name', 'Name', ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  'VB Stuks of ML']) !!}
            <div class="form-text text-muted">
            </div>
        </div>
    </div>

</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Type</button>
    <a href="{!! route('types.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
</div>
