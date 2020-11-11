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
          <a class="nav-link" href="{!! route('clients.index') !!}"><i class="fa fa-list mr-2"></i>Clients</a>
        </li>
        @endcan
        @can('currency-create')
        <li class="nav-item">
          <a class="nav-link" href="{!! route('clients.create') !!}"><i class="fa fa-plus mr-2"></i>Create</a>
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
      {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch']) !!}
      <div class="row">
        @include('clients.fields')
      </div>
      {!! Form::close() !!}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@include('layouts.media_modal')
@endsection
