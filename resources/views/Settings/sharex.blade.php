@extends('layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Mon accès au serveur de Screen :</h4>
                            <div class="">
                                <h4>Status : <span class="badge badge-success">Actif</span></h4>
                                <h4>Token :
                                    <br>
                                    <input type="text" class="form-control" readonly="" value="{{ $data->token }}">
                                </h4>
                                <h4>Dernière utilisation : <button type="button" class="btn btn-purple waves-effect w-md waves-light m-b-5">{{ $data->last_used }}</button></h4>
                                <h4>Dernière IP : {{ $data->last_ip }}</h4>
                                <a href="/settings/sharex-reg" type="button" class="btn btn-info waves-effect w-md waves-light m-b-5">Regénérer</a>
                                <a href="/settings/sharex-down" type="button" class="btn btn-danger waves-effect w-md waves-light m-b-5">Télécharger</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
