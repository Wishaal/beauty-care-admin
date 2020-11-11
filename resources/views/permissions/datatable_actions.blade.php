<div class='btn-group btn-group-sm'>
  @can('currency-list')
  <a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ route('currencies.show', $id) }}" class='btn btn-link'>
    <i class="fa fa-eye"></i>
  </a>
  @endcan

  @can('currency-list')
  <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('currencies.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('currency-list')
{!! Form::open(['route' => ['currencies.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
