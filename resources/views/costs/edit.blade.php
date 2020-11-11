@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <div class="content">
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    @can('currency-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('costs.index') !!}"><i class="fa fa-list mr-2"></i>Costs</a>
                        </li>
                    @endcan
                    @can('currency-create')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('costs.create') !!}"><i class="fa fa-plus mr-2"></i>Create</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-pencil mr-2"></i>Edit</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::model($cost, ['route' => ['costs.update', $cost->id], 'method' => 'patch']) !!}
                    <div class="form-group row ">
                        {!! Form::label('name', 'Description', ['class' => 'col-6 control-label text-left']) !!}
                        <div class="col-6">
                            {!! Form::text('description', null,  ['class' => 'form-control','placeholder'=>  'Description']) !!}
                            <div class="form-text text-muted">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        {!! Form::label('name', 'Price', ['class' => 'col-6 control-label text-left']) !!}
                        <div class="col-6">
                            {!! Form::number('price', null,  ['class' => 'form-control','placeholder'=>  'In SRD']) !!}
                            <div class="form-text text-muted">

                            </div>
                        </div>
                    </div>

                <!-- Submit Field -->
                <div class="form-group col-12 text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Cost</button>
                    <a href="{!! route('costs.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
                </div>

            </div>
            {!! Form::close() !!}
            <div class="clearfix"></div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
