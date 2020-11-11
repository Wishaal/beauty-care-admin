<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->id !!}</p>
  </div>
</div>
<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->name !!}</p>
  </div>
</div><!-- Name Field -->

<div class="form-group row col-6">
  {!! Form::label('price', 'Price:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->price !!} {!! $product->currency->currency !!}</p>
  </div>
</div>
<div class="form-group row col-6">
  {!! Form::label('type', 'Type:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->type->name !!}</p>
  </div>
</div>
<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $product->updated_at !!}</p>
  </div>
</div>

