@extends('layouts.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box">
                            <div class="dropdown pull-right">
                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>

                            <h4 class="header-title m-t-0 m-b-30">Rechercher double compte récent par pseudo</h4>

                            <form>
                                <input type="text" id="player_search" onkeyup="searchPlayer()" class="form-control" size="30">
                                <div id="livesearch"></div>
                            </form>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Pseudo</th>
                                    <th>Casier</th>
                                    <th>Achat</th>
                                    <th>Profile</th>
                                </tr>
                                </thead>
                                <tbody id="search_down">

                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col-->
                    <div class="col-lg-6">
                        <div class="card-box">
                            <div class="dropdown pull-right">
                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>

                            <h4 class="header-title m-t-0 m-b-30">Rechercher tout les doubles comptes par pseudo</h4>

                            <form>
                                <input type="text" id="player_searchIP" onkeyup="searchPlayerIP()" class="form-control" size="30">
                                <div id="livesearch"></div>
                            </form>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Pseudo</th>
                                    <th>Casier</th>
                                    <th>Achat</th>
                                    <th>Profile</th>
                                </tr>
                                </thead>
                                <tbody id="search_down_IP">

                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col-->
                </div>
            </div> <!-- content -->
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('after_scripts')
    <script>
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        var p = getUrlParameter('name');
        console.log(p);
        $('#player_search').val(p);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function searchPlayer() {

            input = document.getElementById("player_search");
            filter = input.value.toUpperCase();
            ul = document.getElementById("search_down");
            li = ul.getElementsByTagName("li");

            last = "";

            $.ajax({
                url: '/moderation/seenaccount/speed',
                type: "POST",
                data: { search_player : filter},
                success: function(data) {
                    data = JSON.parse(data);
                    $("#search_down").empty();
                    for (i = 0; i < data.length; i++) {
                        if (data[i] != last){
                            $("#search_down").append('<tr><th scope="row">' + data[i]["name"] +'</th><td><a href="/moderation/casier/' + data[i]["uniqueId"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td><td><a href="/website/achat/' + data[i]["uniqueId"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td><td><a href="/profile/' + data[i]["uniqueId"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td></tr>');
                            console.log(data[i]);
                        }
                    }
                }
            });
        }


        function searchPlayerIP() {

            input = document.getElementById("player_searchIP");
            filter = input.value.toUpperCase();
            ul = document.getElementById("search_down_IP");
            li = ul.getElementsByTagName("li");

            last = "";

            $.ajax({
                url: '/moderation/seenaccount/long',
                type: "POST",
                data: { search_player : filter},
                success: function(data) {
                    data = JSON.parse(data);
                    $("#search_down_IP").empty();
                    for (i = 0; i < data.length; i++) {
                        if (data[i] != last){
                            $("#search_down_IP").append('<tr><th scope="row">' + data[i]["name"] +'</th><td><a href="/moderation/casier/' + data[i]["name"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td><td><a href="/website/achat/' + data[i]["uniqueId"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td><td><a href="/profile/' + data[i]["uniqueId"] +'" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-wrench"></i> </a></td></tr>');
                            console.log(data[i]);
                        }
                    }
                }
            });
        }
    </script>
@endsection
