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


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Payments</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table responsive">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Services SRD</th>
                    <th>Services USD</th>
                    <th>Services EUR</th>
                    <th>Products SRD</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($client->payments as $r)
                    <tr>
                        @php
                            $srd = 0;
                            $srd = $r->totalsrd - $r->orderPayments->sum('price');

                        @endphp


                        <th>{{ $r->created_at }}</th>
                        <th>{{ $srd }}</th>
                        <th>{{ $r->totalusd }}</th>
                        <th>{{ $r->totaleur }}</th>
                        <th>{{ $r->orderPayments->sum('price') }}</th>
                        <th>  <a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ route('service-payments.edit', $r->id) }}" class='btn btn-link'>
                                <i class="fa fa-eye"></i>
                            </a></th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
