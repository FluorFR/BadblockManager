@extends('layouts/app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">

                <h1>Gestionnaire du raccourcisseur d'URL</h1>

                <br />
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_createURL" onclick="createRandomURL()">Créer un URL</button>

                        <div class="modal fade" id="modal_createURL" tabindex="-1" role="dialog" aria-labelledby="modal_createURL" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modal_createURL_title">Créer un nouvel URL</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="urlToShort">Copier l'URL à raccourcir :</label><br />
                                                <input type="text" id="modal_createURL_urlToShort" class="form-control" />
                                            </div>

                                            <div class="form-group row">
                                                <label>Personnalisez votre URL (Caractères alphanumériques et _- seulement) :</label><br />

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ $URLShortener_domain }}</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="modal_createURL_shortenedURL">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="createOrModifyURL('-1')">Créer l'URL</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <br />

                <div class="row">
                    <div class="col-12">
                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th scope="col">URL original</th>
                                <th scope="col">URL raccourci</th>
                                <th scope="col">Clics joueurs</th>
                                <th scope="col">Clics extérieurs</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($URLs_all as $i => $row)
                                <tr>
                                    <td style="display: none;">
                                        <input type="text" id="url_id_{{ $i }}" class="form-control" value="{{ $row['_id'] }}" />
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-xs-2 input-group">
                                                <input type="text" id="url_large_{{ $i }}" class="form-control" value="{{ $row["url_origin"] }}" readonly />
                                                <button type="button" class="btn" onclick="CopyToClipboard('url_large_{{ $i }}')"> <i class='fa fa-clipboard'></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-xs-2 input-group">
                                                <input type="text" id="url_shortened_{{ $i }}" class="form-control" value="{{ $row["url_shortened"] }}" readonly />
                                                <button type="button" class="btn" onclick="CopyToClipboard('url_shortened_{{ $i }}')"> <i class='fa fa-clipboard'></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $row["clickCounter_BadblockPlayers"] }}</td>
                                    <td>{{ $row["clickCounter_Unregistered"] }}</td>

                                   <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_changeURL_{{ $i }}">Modifier l'URL</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_confirmDelete_{{ $i }}">Supprimer</button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modal_changeURL_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="modal_changeURL_{{ $i }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modal_changeURL_title_{{ $i }}">Modifier un URL</h4>
                                            </div>
                                            <div class="modal-body form-group">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="modal_changeURL_urlToShort_{{ $i }}">Modifier l'URL de destination :</label><br />
                                                        <input type="text" id="modal_changeURL_urlToShort_{{ $i }}" class="form-control" value="{{ $row['url_origin'] }}" />
                                                    </div>

                                                    <div class="form-group row">
                                                        <label>Modifier l'URL personnalisé :</label><br />

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">https://bblock.pw/</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="modal_changeURL_shortenedURL_{{ $i }}" value="{{ str_replace($URLShortener_domain, "", $row['url_shortened']) }}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" onclick="createOrModifyURL('{{ $i }}')">Modifier l'URL</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_confirmDelete_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="modal_changeURL_{{ $i }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modal_confirmDelete_title_{{ $i }}">Supprimer un URL</h4>
                                            </div>
                                            <div class="modal-body form-group">
                                                <p>/!\ Attention, supprimer le lien rendra inopérant les futurs clics /!\</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteURL('{{ $i }}')">Supprimer l'URL</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

        function createRandomURL() {
            var randomURL = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 7; i++)
                randomURL += possible.charAt(Math.floor(Math.random() * possible.length));

            $('#modal_createURL_shortenedURL').val(randomURL);
        }

        function deleteURL(i){
            $.ajax({
                type: "POST",

                url: "/section/url-shortener",

                data: {
                    "urlToDelete": $("#url_id_"+i).val(),
                    "comesFrom": "delete"
                },

                success: function(){
                    toastr.success("Vous avez bien supprimé l'URL", 'Succès !');
                },

                error: function (jqxhr, status, exception) {
                    toastr.error("Erreur lors de la suppression, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                }
            });
        }

        function createOrModifyURL(i){

            var URLToShort;
            var URLShortened;
            var comesFrom;
            var id;

            if(i == "-1") {
               URLToShort = $('#modal_createURL_urlToShort').val();
               URLShortened = $('#modal_createURL_shortenedURL').val();
               comesFrom = "create";
               id = "-1"
            }

            else {
                URLToShort = $('#modal_changeURL_urlToShort_'+i).val();
                URLShortened = $('#modal_changeURL_shortenedURL_'+i).val();
                id = $('#url_id_'+i).val();
                comesFrom = "modify";
            }

            if(URLToShort != "" && URLShortened != "") {

                $.ajax({
                    type: "POST",

                    url: "/section/url-shortener",

                    data: {
                        "id": id,
                        "urlToShort": URLToShort,
                        "urlShortened": URLShortened,
                        "comesFrom": comesFrom
                    },

                    success: function(){
                        var successMessage;
                        if(comesFrom == "create"){
                            successMessage = "créé";
                        }
                        else {
                            successMessage = "modifié"
                        }
                        toastr.success("L'URL a bien été "+successMessage, 'Succès !');
                    },

                    error: function (jqxhr, status, exception) {

                        if(exception == "Conflict"){
                            exception = Object.values($.parseJSON(Object.values(jqxhr)["16"]))["0"];
                        }

                        toastr.error("Erreur lors de la création. Intitulé de l'erreur : " + exception, 'Erreur');
                    }
                });
            }

            else {
                toastr.error('Merci de compléter tout le formulaire', 'Erreur');
            }
        }

    </script>

@endsection