@extends('layouts.app')

@section('header')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-4">
            <div class="card-box">
                <h4 class="header-title m-t-0">Node01 MongoDB : <span id="mongoTi" class="label label-purple"> Unknown </span></h4>
                <div class="widget-chart text-center">
                    <table class="table m-0">
                        <tbody>
                        <tr>
                            <th scope="row">Current Clients</th>
                            <td><span id="mongoMs" class="label label-default">Unknown</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Uptime</th>
                            <td><span id="mongoUp" class="label label-default">Unknown</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('after_scripts')
    <script>
        var resizefunc = [];

        var timer, delay = 3000;

        timer = setInterval(function(){
            $.ajax({
                type    : 'get',
                url     : '/infra/mongodb-ajax',
                dataType: 'json',
                success : function(data){

                    data = jQuery.parseJSON(JSON.stringify(data));

                    if (data.on = 1){
                        if(data.load > data.ms * 2){
                            $("#mongoLoad").attr('class',"label label-danger");
                        }else if(data.load > data.ms){
                            $("#mongoLoad").attr('class',"label label-warning");
                        }else{
                            $("#mongoLoad").attr('class',"label label-success");
                        }

                        $("#mongoTi").text("En service");
                        $("#mongoTi").attr('class',"label label-success");
                        $("#mongoMs").attr('class',"label label-success");
                        $("#mongoUp").attr('class',"label label-success");
                        $("#mongoMs").text(data.ms + " ms");
                        $("#mongoUp").text(data.uptime);
                        $("#mongoLoad").text(data.load + "ms");
                    }else{
                        $("#mongoTi").text("Unknown");
                        $("#mongoTi").attr('class',"label label-danger");
                        $("#mongoMs").attr('class',"label label-danger");
                        $("#mongoUp").attr('class',"label label-danger");
                        $("#mongoLoad").attr('class',"label label-danger");
                        $("#mongoMs").text("Unknown");
                        $("#mongoUp").text("Unknown");
                        $("#mongoLoad").text("Unknown");
                    }
                },
                error : function(data){
                    $("#mongoTi").text("Unknown");
                    $("#mongoTi").attr('class',"label label-danger");
                    $("#mongoMs").attr('class',"label label-danger");
                    $("#mongoUp").attr('class',"label label-danger");
                    $("#mongoLoad").attr('class',"label label-danger");
                    $("#mongoMs").text("Unknown");
                    $("#mongoUp").text("Unknown");
                    $("#mongoLoad").text("Unknown");
                }
            });
        }, delay);
    </script>

@endsection
