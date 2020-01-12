@extends('layouts.app')
@section('content')
                <h1>Statistiques de connection & productvité builder :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pseudo</th>
                                            <th>Temps de connection</th>
                                            <th>Blocs placés</th>
                                            <th>Blocs cassés</th>
                                            <th>Commandes</th>
                                            <th>Ratio</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Top as $k => $user)
                                            <tr class="gradeX">
                                                <td>{{ $k }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ round(($user->login / 60 / 60), 2) }} Heures</td>
                                                <td>{{ $user->placedBlocks }}</td>
                                                <td>{{ $user->brokenBlocks }}</td>
                                                <td>{{ $user->commands }}</td>
                                                <td>
                                                    <div class="widget-chart-box-1">
                                                        <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                                                               data-bgColor="#FFE6BA" value="
                                                                   @if($user->placedBlocks == 0 || $user->brokenBlocks == 0 || $user->commands == 0)
                                                                0
                                                                @else
                                                        {{ round(round((($user->placedBlocks + $user->brokenBlocks+ $user->commands) * 1.8 / $user->login), 2)  * 100, 1) }}
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