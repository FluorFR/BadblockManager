@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
        <a href="#" class="btn btn-icon btn-warning waves-light"  data-toggle="modal" data-target="#openInstance"> <i class="fas fa-plus-square"></i> New Instance</a>
        <a href="#" class="btn btn-icon btn-danger waves-light" data-toggle="modal" data-target="#closeInstance"> <i class="fas fa-minus-square"></i> Stop Instance</a>
        <div class="pull-right">
            <a href="#" class="btn btn-icon btn-info waves-light" onclick="viewcluster();"> <i class="fas fa-network-wired"></i> Vue Cluster</a>
            <a href="#" class="btn btn-icon btn-info waves-light" onclick="viewinstance();"> <i class="fas fa-server"></i> Vue Instances</a>
        </div>
        <br>
        <br>
        <div id="cluster">
            <div class="row">
                @foreach($Clusters as $Cluster)
                    @include('infra.cluster')
                @endforeach
            </div>
        </div>
        <div id="instances" style="display: none">
            @include('infra.instances')
        </div>
@endsection
@section('after_scripts')
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        function viewcluster() {
            $('#instances').hide();
            $('#cluster').show();
        }
        function viewinstance() {
            $('#cluster').hide();
            $('#instances').show();
        }
    </script>


    <div id="openInstance" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myLargeModalLabel">Ouverture d'une nouvelle Instance :</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="openInst">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Cluster</label>
                            <div class="col-10">
                                <select class="form-control" name="cluster">
                                    @foreach($Clusters as $Cluster)
                                        <option value="{{ $Cluster['name'] }}">{{ $Cluster['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">World System Name</label>
                            <div class="col-10">
                                <select class="form-control" name="WorldSystemName">
                                    @foreach($Type_List as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Owner</label>
                            <div class="col-10">
                                <input type="test" id="owner" name="owner" class="form-control" placeholder="Fluor" value="{{Auth::user()->name}}">
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-icon btn-success"> <i class="fas fa-check-square"></i> Valider</button>
                        </center>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script>

        $("#openInst").submit(function(e) {
            var form = $(this);

            $.ajax({
                type: "POST",
                url: "/infra/docker/ajax/open",
                data: form.serialize(),
                success: function(data)
                {
                    toastr.success("L'Envoie de l'ordre d'ouverture à bien était envoyé !", "Succès !");
                    console.log('Valider !');
                },
                error: function(data)
                {
                    toastr.error('Un problème s\'est produit ou vos permissions sont insuffisantes !', 'Erreur !');
                    console.log('Erreur !');
                }
            });
            e.preventDefault();
        });
    </script>
    

    <div id="closeInstance" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myLargeModalLabel">Stoper Instance :</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="closeInst">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Instance Name</label>
                            <div class="col-10">
                                <input id="owner" name="InstanceName" class="form-control" placeholder="tower2v2_011">
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-icon btn-success"><i class="fas fa-check-square"></i>
                                Valider
                            </button>
                        </center>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        $("#closeInst").submit(function(e) {
            var form = $(this);

            $.ajax({
                type: "POST",
                url: "/infra/docker/ajax/close",
                data: form.serialize(),
                success: function(data)
                {
                    toastr.success("L'Envoie de l'ordre de fermeture à bien était envoyé !", "Succès !");
                    console.log('Valider !');
                },
                error: function(data)
                {
                    toastr.error('Un problème s\'est produit ou vos permissions sont insuffisantes !', 'Erreur !');
                    console.log('Erreur !');
                }
            });
            e.preventDefault();
        });
    </script>

    <script>
        setInterval(function(){
            $("#instances").load("/infra/docker/ajax","");
        }, 5000);

    </script>

@endsection
