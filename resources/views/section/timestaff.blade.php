@extends('layouts.app')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Temps de connection :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>Pseudo</th>
                                                <th>Grade</th>
                                                <th>Temps de connection</th>
                                                <th>Objectif de connection</th>
                                                <th>Sanction</th>
                                                <th>Objectif de Sanctions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user as $row)
                                                <tr class="gradeX">
                                                    <td>{{ $row['name'] }}</td>
                                                    <td>{{ $row['grade'] }}</td>
                                                    <td>{{ round(($row['time'] / 60 / 60), 2) }} Heures</td>
                                                    <td>
                                                        <div class="widget-chart-box-1">
                                                            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                                                                   data-bgColor="#FFE6BA" value="
                                                                   @if(round(($row['time'] / 60 / 60), 2) / $row['ntime']  * 100 > 100)
                                                                    100
                                                                    @else
                                                                    {{ round(round(($row['time'] / 60 / 60), 2) / $row['ntime']  * 100, 1) }}
                                                                    @endif"
                                                                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                                                                   data-thickness=".15"/>
                                                        </div>
                                                    </td>
                                                    <td>{{ $row['Punish'] }}</td>
                                                    <td>
                                                        <div class="widget-chart-box-1">
                                                            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                                                                   data-bgColor="#FFE6BA" value="
                                                                   @if(round($row['PunishTime'] / $row['time'], 2) > 0.5)
                                                                    100
                                                                    @else
                                                                    {{ round($row['PunishTime'] / $row['time'], 2) * 2 }}
                                                                    @endif"
                                                                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                                                                   data-thickness=".15"/>
                                                        </div>
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