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
                                {{ Form::open(array('url' => "/animation/pb",'class'=>'form_inline')) }}
                                    <div class="">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Pseudo</th>
                                                <th>Point Boutique</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tablee">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="pseudo[]" class="form-control input-block" value="">                                                </td>
                                                    <td>
                                                        <input type="text" name="points[]" class="form-control input-block" value="">                                                </td>
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
            $('#tablee').append('<tr>\n' +
                '                                                    <td>\n' +
                '                                                        <input type="text" name="pseudo[]" class="form-control input-block" value="">                                                </td>\n' +
                '                                                    <td>\n' +
                '                                                        <input type="text" name="points[]" class="form-control input-block" value="">                                                </td>\n' +
                '                                                    </td>\n' +
                '                                                </tr>')
        }
    </script>


@endsection