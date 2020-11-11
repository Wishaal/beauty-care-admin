<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Description:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $cost->description !!}</p>
  </div>
</div><!-- Name Field -->

<div class="form-group row col-6">
  {!! Form::label('price', 'Price:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $cost->price !!}</p>
  </div>
</div><!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $cost->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $cost->updated_at !!}</p>
  </div>
</div>

