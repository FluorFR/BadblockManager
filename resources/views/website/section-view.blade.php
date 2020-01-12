@extends('layouts.app')
@section('content')
    <br>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <h1>Paies de la section : {{ $data['section'] }}</h1>
                                <h2>Date : {{ $data['date'] }}</h2>
                                <h2>Total : {{ $data['total'] }}</h2>
                                <a href="/" class="btn btn-primary waves-effect waves-light">Retour <i class="fa fa-long-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <table class="table table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>Pseudo</th>
                                <th>Points</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['data'] as $key => $value)
                                <tr class="gradeX">
                                    <td>{{ $value['Pseudo'] }}</td>
                                    <td>{{ $value['points'] }}</td>
                                    <td>
                                        @if(isset($value['commentaire']))
                                            {{ $value['commentaire'] }}
                                        @else
                                            Pas de commentaire
                                        @endif
                                    </td>
                                    <td class="actions">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
