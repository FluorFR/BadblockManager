@extends('layouts.app')

@section('header')

    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <h1>Transférer un shematic vers le FTP</h1>

                <br /><br />

                <form method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="custom-file col-4">
                        <input type="file" class="custom-file-input" id="uploadedFile" name="uploadedFile" lang="fr-FR" />
                        <label class="custom-file-label" for="uploadedFile">Choisir le fichier</label>
                    </div>
                    <br /><br />
                    <button class="btn btn-primary" onclick="uploadFile()">Envoyer le fichier</button>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('after_scripts')

    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        function uploadFile(){

            var file = $('#uploadedFile').val();

            if(file != 'undefined' && file != "") {
                $.ajax({
                    url: '/profil/file-uploader',

                    method: 'POST',

                    data: {
                        'uploadedFile': file
                    },

                    success: function (jqxhr, status, successMessage) {
                        toastr.success(successMessage, "Succès");
                    },

                    error: function (jqxhr, status, exception) {

                        if(exception == "Conflict"){
                            exception = Object.values($.parseJSON(Object.values(jqxhr)["16"]))["0"];
                        }

                        toastr.error("Erreur lors de l'envoi, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                    }
                });
            }
        }
    </script>

    @endsection