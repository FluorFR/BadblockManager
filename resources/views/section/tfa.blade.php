@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Vérification des TFA : Foueter des cul un peu</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped" id="datatable-editable">
                                            <thead>
                                            <tr>
                                                <th>Pseudo</th>
                                                <th>Mode premium</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user as $row)
                                                @if(!isset($row['authKey']) || empty($row['authKey']))
                                                    <tr class="gradeX">
                                                        <td>{{ $row['name'] }}</td>
                                                        <td>
                                                            @if($row['onlineMode'] == true)
                                                                <i class="fa fa-check"></i>
                                                            @else
                                                                <i class="fa fa-ban"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-icon waves-effect waves-light btn-danger m-b-5">
                                                                <i class="fa fa-legal"></i>
                                                            </button>
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