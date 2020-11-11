<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $client->id !!}</p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $client->name !!}</p>
  </div>
</div>

<div class="form-group row col-6">
    {!! Form::label('number', 'Number:', ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
        <p>{!! $client->number !!}</p>
    </div>
</div>

<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('Created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $client->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $client->updated_at !!}</p>
  </div>
</div>

