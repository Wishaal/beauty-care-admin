<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->id !!}</p>
  </div>
</div>

<div class="form-group row col-6">
  {!! Form::label('duration', 'Duration:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->duration !!}</p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->name !!}</p>
  </div>
</div><!-- Name Field -->

<div class="form-group row col-6">
  {!! Form::label('price', 'Price:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->price !!} {!! $service->currency->currency !!}</p>
  </div>
</div>
<div class="form-group row col-6">
  {!! Form::label('category', 'Category:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->category->name !!}</p>
  </div>
</div>
<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $service->updated_at !!}</p>
  </div>
</div>

