@extends('layouts.app')

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <h1 class="page-title">Badblock Manager</h1>

                <div class="row">

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <h4 class="header-title mt-0 m-b-30">Joueurs connectés</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2">
                                    <h2 class="mb-0" id="players"> 0 </h2>
                                    <p class="text-muted m-b-25">Joueurs connecté(s)</p>
                                </div>
                                <div class="progress progress-bar-success-alt progress-sm mb-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <h4 class="header-title mt-0 m-b-30">Joueurs bannis</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2">
                                    <h2 class="mb-0" id="players-ban"> 0 </h2>
                                    <p class="text-muted m-b-25">Joueurs bannis</p>
                                </div>
                                <div class="progress progress-bar-danger-alt progress-sm mb-0">
                                    <div class="progress-bar progress-bar-danger" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <h4 class="header-title mt-0 m-b-30">Objectif (en %)</h4>

                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1">
                                    <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                                           data-bgColor="#FFE6BA" value="
                                                                   @if(round(($stats['time'] / 60 / 60), 2) / $stats['ntime']  * 100 > 100)
                                            100
@else
                                    {{ round(round(($stats['time'] / 60 / 60), 2) / $stats['ntime']  * 100, 1) }}
                                    @endif"
                                           data-skin="tron" data-angleOffset="180" data-readOnly=true
                                           data-thickness=".15"/>
                                </div>

                                <div class="widget-detail-1">
                                    <h2 class="p-t-10 mb-0"> {{ round(($stats['time'] / 60 / 60), 2) }} Heures </h2>
                                    <p class="text-muted m-b-10">Temps de jeu ce mois</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <h4 class="header-title mt-0 m-b-30">Objectif Sanctions (en %)</h4>

                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1">
                                    <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                                           data-bgColor="#FFE6BA" value="
                                                                   @if(round($stats['PunishTime'] / $stats['time'], 2) > 0.5)
                                            100
@else
                                    {{ round($stats['PunishTime'] / $stats['time'], 2) * 2 }}
                                    @endif"
                                           data-skin="tron" data-angleOffset="180" data-readOnly=true
                                           data-thickness=".15"/>
                                </div>

                                <div class="widget-detail-1">
                                    <h2 class="p-t-10 mb-0"> {{ $stats['Punish'] }} Sanctions </h2>
                                    <p class="text-muted m-b-10">Sanctions ce mois (Mute/Warn/Ban/Kick)</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <script>

        function players() {
            //Get players
            $.getJSON('/api/minecraft', function(data) {
                $('#players').html(data.players.now);
                console.log('%c' + data.players.now + " connectés !", 'background: #222; font-size: 2em; color: #9b59b6');
                setTimeout(players, 5000);
            });
        }
        players();

        function ban() {
            //Get players
            $.getJSON('/api/ban', function(data) {
                $('#players-ban').html(data.players.now);
                console.log('%c' + data.players.now + " joueurs bannis!", 'background: #222; font-size: 2em; color: #9b59b6');
                setTimeout(ban, 10000);
            });
        }
        ban();

    </script>

@endsection
