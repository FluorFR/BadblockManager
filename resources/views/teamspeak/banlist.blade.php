@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Liste de bans TeamSpeak :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Pseudo / IP / UID</th>
                                            <th>Date</th>
                                            <th>Durée</th>
                                            <th>Banner</th>
                                            <th>Raison</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ban as $row)
                                            @if(isset($row["lastnickname"]))
                                                <tr class="gradeX">
                                                    <td>{{ $row["banid"] }}</td>
                                                    <td>{{ $row["lastnickname"] }}</td>
                                                    <td>{{ date("Y-m-d H:i:s", $row["created"]) }}</td>
                                                    <td>{{ $row["duration"] }}</td>
                                                    <td>{{ $row["invokername"] }}</td>
                                                    <td>{{ $row["reason"] }}</td>
                                                    <td>
                                                        <button class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                                                    </td>
                                                </tr>
                                            @elseif(isset($row["ip"]))
                                                <tr class="gradeX">
                                                    <td>{{ $row["banid"] }}</td>
                                                    <td>{{ $row["ip"] }}</td>
                                                    <td>{{ date("Y-m-d H:i:s", $row["created"]) }}</td>
                                                    <td>{{ $row["duration"] }}</td>
                                                    <td>{{ $row["invokername"] }}</td>
                                                    <td>{{ $row["reason"] }}</td>
                                                    <td>
                                                        <button class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="gradeX">
                                                    <td>{{ $row["banid"] }}</td>
                                                    <td>{{ $row["uid"] }}</td>
                                                    <td>{{ date("Y-m-d H:i:s", $row["created"]) }}</td>
                                                    <td>{{ $row["duration"] }}</td>
                                                    <td>{{ $row["invokername"] }}</td>
                                                    <td>{{ $row["reason"] }}</td>
                                                    <td>
                                                        <button class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

    <script type="text/javascript">
        $(document).ready(function () {
            // Default Datatable
            $('#datatable').DataTable();
        });
    </script>

@endsection
