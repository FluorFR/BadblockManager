@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Give animation</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                {{ Form::open(array('url' => "/animation/item",'class'=>'form_inline')) }}
                                    <div class="">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Pseudo</th>
                                                <th>Items</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tablee">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="pseudo[]" class="form-control input-block" value="">                                                </td>
                                                    <td>
                                                        <select name="give[]" class="form-control select2">
                                                            <option>Produit</option>
                                                            @foreach($item as $row)
                                                                <option value="{{ $row['_id'] }}">
                                                                    @if(isset($row['queue']))
                                                                        {{ $row['queue'] }} -
                                                                    @endif
                                                                    {{ $row['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <center>
                                            <button type="button" class="btn btn-danger" onclick="add();"><span class="fa fa-plus"></span> Add line</button>
                                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Valider</button>
                                        </center>
                                    </div>
                                {{ Form::close() }}
</div>
<!-- end: panel body -->

</div> <!-- end panel -->
</div> <!-- end col-->
</div>
<!-- end row -->

</div>
</div>
</div>
@endsection
@section("after_scripts")

<!-- Editable js -->
<script src="/assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="/assets/plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/assets/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="/assets/plugins/tiny-editable/numeric-input-example.js"></script>
<!-- init -->
<script src="/assets/pages/datatables.editable.init.js"></script>

    <script>
        function add() {
            $('#tablee').append("<tr>\n" +
                "                                                    <td>\n" +
                "                                                        <input type=\"text\" name=\"pseudo[]\" class=\"form-control input-block\" value=\"\">                                                </td>\n" +
                "                                                    <td>\n" +
                "                                                        <select name=\"give[]\" class=\"form-control select2\">\n" +
                "                                                            <option>Produit</option>\n" +
                "                                                            @foreach($item as $row)\n" +
                "                                                                <option value=\"{{ $row['_id'] }}\">@if(isset($row['queue'])) {{ $row['queue'] }} - @endif{{ $row['name'] }}</option>\n" +
                "                                                            @endforeach\n" +
                "                                                        </select>\n" +
                "                                                    </td>\n" +
                "                                                </tr>")
        }
    </script>


@endsection