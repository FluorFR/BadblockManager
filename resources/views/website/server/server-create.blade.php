@extends('layouts.app')
<link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

@section('content')
    <br>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <h1>Création d'un nouveau Serveur.</h1>
                            </div>
                        </div>
                    </div>



                    <div class="">
                        {{ Form::open(array('url' => "/website/crud/server" ,'class'=>'form_inline')) }}
                        Nom du serveur :
                        {{ Form::text('name', "", array('class' => 'form-control','placeholder'=>"Nom d'affichage du Serveur")) }}
                        <br>
                        Nom réel du serveur :
                        {{ Form::text('realname', "", array('class' => 'form-control','placeholder'=>"Nom réel du Serveur")) }}
                        <br>
                        Icone FA du serveur :
                        {{ Form::text('icon', "", array('class' => 'form-control','placeholder'=>"icon icon-cloud")) }}
                        <br>
                        Power du serveur :
                        {{ Form::text('power', "", array('class' => 'form-control','placeholder'=>"0-10")) }}
                        <br>
                        Activer la visibilitée du serveur sur le site :
                        <br>
                        <br>
                        <input name ="visibility" type="checkbox" checked data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        <br>
                        Item pour boutique Ingame :
                        {{ Form::text('ig_material',  "", array('class' => 'form-control','placeholder'=>"")) }}
                        <br>
                        <br>
                        Ingame data :
                        {{ Form::text('ig_data', "", array('class' => 'form-control','placeholder'=>"")) }}
                        <br>
                        <br>

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Save</button>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
<script src="/assets/plugins/switchery/switchery.min.js"></script>
ss
