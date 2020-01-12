@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Validation des préfix :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                {{ Form::open(array('url' => "/website/prefix"  ,'class'=>'form_inline')) }}
                                    <div class="">
                                        <table class="table table-striped" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>Préfix</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $row)
                                                <tr class="gradeX">
                                                    <td>{{ $row['prefix_new'] }}
                                                        <input type="hidden" name="list[]" value="{{ $row['uniqueId'] }}">
                                                        <input type="hidden" name="prefix[]" value="{{ $row['prefix_new'] }}">
                                                    </td>
                                                    <td>
                                                        <select name="val[]" class="form-control">
                                                            <option value="false">En attente</option>
                                                            <option value="true">Valider</option>
                                                            <option value="refused">Refusé</option>
                                                        </select>
                                                    <td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <center><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Valider</button></center>
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

@endsection