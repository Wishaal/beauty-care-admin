<table class="table table-bordered" id="dynamicTable">

    <tr>
        <th>Description Cost</th>
        <th>Price</th>

    </tr>
    <tr id='toClone' class="remove-tr">
        <td>
            {!! Form::text('description[]', null,  ['id' =>'description_1','class' => 'form-control','placeholder'=>  'Description']) !!}</td>
           <td>
            {!! Form::number('price[]', null,  ['id' => 'price_1','class' => 'form-control','placeholder'=>  'Price in SRD']) !!}</td>
    </tr>
    <tr id="beforeClone">

        <td colspan="2">
            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
        </td>

    </tr></table>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Cost</button>
    <a href="{!! route('costs.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
</div>

@section('js')
    <script type="text/javascript">
        var i = 1;
        $("#add").click(function () {
            ++i;
            // Create clone of <div class='input-form'>
            var newel = $('#toClone:last').clone();
            // Add after last <div class='input-form'>
            $(newel).insertBefore("#beforeClone:last");
            $(newel).find('td:last').after('<td><input type="button" class="btn btn-danger remove-tr" name="REMOVE" value="X" /></td>');

            $(newel).find('#description_1').attr('id', 'description_' + i).attr('name', 'description[]').val('');
            $(newel).find('#price_1').attr('id', 'price_' + i).attr('name', 'price[]').val('');

        });

        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });

    </script>
@stop
