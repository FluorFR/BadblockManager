@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">

                    <h1>Gestion des youtubers</h1>
                    <br /><br />

                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_createYoutuber">Ajouter un Youtuber</button>

                            <div class="modal fade" id="modal_createYoutuber" tabindex="-1" role="dialog" aria-labelledby="modal_createYoutuber" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modal_createYoutuber_title">Ajouter un nouveau Youtuber</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="modal_createYoutuber_youtuberName">Entrez le nom du Youtuber :</label>
                                                    <input type="text" id="modal_createYoutuber_youtuberName" class="form-control" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="modal_createYoutuber_URL">Entrez l'URL de la chaîne</label>
                                                    <input type="text" class="form-control" id="modal_createYoutuber_URL" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="modal_createYoutuber_power">Entrez le power du Youtuber</label>
                                                    <input type="number" class="form-control" id="modal_createYoutuber_power" min="0" max="100" />
                                                </div>
                                            </form>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="createYoutuber()">Ajouter le Youtuber</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                    <br /><br />

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-stripped">
                                <thead>
                                <tr>
                                    <th scope="col">Nom du youtuber</th>
                                    <th scope="col">UUID</th>
                                    <th scope="col">Power</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Youtubers as $i => $row)
                                    <tr>
                                        <td class="col-4">
                                            <div class="input-group">
                                                <input  type="text" id="youtuber_{{ $i }}_name" class="form-control" value="{{ $row['youtuber_name'] }}" readonly />
                                                <button type="button" class="btn" onclick="CopyToClipboard('youtuber_{{ $i }}_name')"> <i class='fa fa-clipboard'></i></button>
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <div class="input-group">
                                                <input type="text" id="youtuber_{{ $i }}_uuid" class="form-control" value="{{ $row['youtuber_uuid'] }}" readonly />
                                                <button type="button" class="btn" onclick="CopyToClipboard('youtuber_{{ $i }}_uuid')"> <i class='fa fa-clipboard'></i></button>
                                            </div>
                                        </td>
                                        <td>{{ $row['youtuber_power'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_confirmDelete_{{ $i }}">Supprimer</button>
                                        </td>



                                        <div class="modal fade" id="modal_confirmDelete_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="modal_confirmDelete_{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="modal_confirmDelete_title_{{ $i }}">Supprimer un Youtuber</h4>
                                                    </div>
                                                    <div class="modal-body form-group">
                                                        <p>Êtes-vous sûr ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteYoutuber('{{ $i }}')">Supprimer l'URL</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

    @endsection

@section('after_scripts')

    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        function CopyToClipboard(containerid) {
            var copyText = document.getElementById(containerid);
            copyText.select();
            document.execCommand("copy");
        }

        function createYoutuber(){

            youtuber_name = $('#modal_createYoutuber_youtuberName').val();
            youtuber_url = $('#modal_createYoutuber_URL').val();
            youtuber_power = $('#modal_createYoutuber_power').val();

            if(youtuber_name != '' && youtuber_url != '' && youtuber_power != "") {
                if (youtuber_power >= 0 && youtuber_power <= 100) {
                    $.ajax({

                        method: 'POST',

                        url: '/section/youtubers',

                        data: {
                            'youtuber_name': youtuber_name,
                            'youtuber_url': youtuber_url,
                            'youtuber_power': youtuber_power,
                            "comesFrom": "create"
                        },

                        success: function () {
                            toastr.success('Le Youtuber a bien été créé', "Succès !");
                        },

                        error: function (jqxhr, status, exception) {

                            if (exception == "Conflict") {
                                exception = Object.values($.parseJSON(Object.values(jqxhr)["16"]))["0"];
                            }

                            toastr.error("Erreur lors de la création. Intitulé de l'erreur : " + exception, 'Erreur');
                        }
                    });
                }
                else {
                    toastr.error("Merci d'indiquer un power compris entre 0 et 100", "Erreur !");
                }
            }
            else {
                toastr.error('Merci de compléter tout le formulaire', "Erreur !");
            }
        }

        function deleteYoutuber(i){

            $.ajax({

                method: 'POST',

                url: '/section/youtubers',

                data: {
                    'youtuber_name': $('#youtuber_'+i+'_name').val(),
                    "comesFrom": "delete"
                },

                success: function(){
                    toastr.success('Le Youtuber a bien été supprimé', "Succès !");
                },

                error: function (jqxhr, status, exception) {

                    if(exception == "Conflict"){
                        exception = Object.values($.parseJSON(Object.values(jqxhr)["16"]))["0"];
                    }

                    toastr.error("Erreur lors de la création. Intitulé de l'erreur : " + exception, 'Erreur');
                }
            });
        }
    </script>

@endsection