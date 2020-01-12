@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Permissions serveur :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped" id="datatable-editable">
                                            <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Power</th>
                                                <th>Editer</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $row)
                                                @if(!isset($row['authKey']) || empty($row['authKey']))
                                                    <tr class="gradeX">
                                                        <td>{{ $row['name'] }}</td>
                                                        <td>{{ $row['power'] }}</td>
                                                        <td>
                                                            <a href="/section/permission-serv/{{ $row['_id'] }}" class="btn btn-icon waves-effect waves-light btn-danger m-b-5">
                                                                <i class="fa fa-legal"></i>
                                                            </a>
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


@endsection