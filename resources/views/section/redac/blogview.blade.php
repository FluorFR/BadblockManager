@extends('layouts.app')
@section('content')
                <h1>Statistiques de vue du blog :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Titre</th>
                                            <th>Vue(s)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Blog as $k => $b)
                                            <tr class="gradeX">
                                                <td>{{ $b['uid'] }}</td>
                                                <td>{{ $b['title'] }}</td>
                                                <td>{{ count($b['view']) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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