@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-page">
        <div id="vueapp" class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title">Messages à traiter</h4>
                            <div class="card-box">
                                <div class="container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Joueur</th>
                                                <th>Date</th>
                                                <th>Message</th>
                                                <th>Sanction</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="messages_list">

                                        </tbody>
                                    </table>
                                    <div>
                                </div>
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

        function getMessage() {
            $.ajax({
                url: '/moderation/guardian/ajax/unprocessed-messages',
                type: "GET",
                data: {},
                success: function(data) {
                    data = JSON.parse(data);
                    $("#messages_list").empty();
                    console.log(data);
                    for (i = 0; i < data.length; i++) {
                        console.log(data[i]);
                        $("#messages_list").append("<tr id='"+ data[i]['_id']['$oid'] +"'>\n" +
                            "                                                <td>" + data[i].playerName + "</td>\n" +
                            "                                                <td>" + data[i].date + "</td>\n" +
                            "                                                <td>\n" +
                            "                                                    <p style=\"max-width: 250px;\">\n" +
                            "                                                    " + data[i].message + "\n" +
                            "                                                    </p>\n" +
                            "                                                </td>\n" +
                            "                                                <td id='calcul" + data[i]['_id']['$oid'] +"'>Calcul...</td>\n" +
                            "                                                <td class=\"row messageButtons\">\n" +
                            "                                                    <button onclick='sendSanction(\""+ data[i]['_id']['$oid'] +"\")' class=\"btn btn-success\">\n" +
                            "                                                        <i class=\"fas fa-check-square\"></i>\n" +
                            "                                                    </button>\n" +
                            "                                                    <button onclick='setok(\"" + data[i]['_id']['$oid'] +"\")' class=\"btn btn-danger\">\n" +
                            "                                                        <i class=\"fas fa-trash-alt\"></i>\n" +
                            "                                                    </button>\n" +
                            "                                                </td>\n" +
                            "                                            </tr> ");
                        calculSanction(data[i]['_id']['$oid']);
                    }
                }
            });
            setTimeout(getMessage, 50000);
        }
        getMessage();
        
        
        function calculSanction(uuid) {
            $.ajax({
                url: '/moderation/guardian/ajax/jsonsanc-message/' + uuid,
                type: "GET",
                data: {},
                success: function(data) {
                    data = JSON.parse(data);
                    $("#calcul" + uuid).empty();
                    if (data.type != null){
                        $("#calcul" + uuid).append(data.type + " " + data.time + " " + data.reason);
                    }else{
                        $("#calcul" + uuid).append("N/A");
                    }
                }
            });
            
        }

        function setok(uuid) {
            $("#" + uuid).remove();
            $.ajax({
                url: '/moderation/guardian/ajax/set-message-ok/' + uuid,
                type: "GET",
                data: {},
                success: function(data) {

                }
            });
        }

        function sendSanction(uuid) {
            $.ajax({
                url: '/moderation/guardian/ajax/sancsend-message/' + uuid,
                type: "GET",
                data: {},
                success: function(data) {
                    $("#" + uuid).remove();
                }
            });
        }


    </script>
@endsection
