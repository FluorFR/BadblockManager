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
                                <h1>Création d'une nouvelle Catégorie.</h1>
                            </div>
                        </div>
                    </div>



                    <div class="">
                        {{ Form::open(array('url' => "/website/crud/category" ,'class'=>'form_inline')) }}
                        Nom d'affichage de la categorie :
                        {{ Form::text('name', "", array('class' => 'form-control','placeholder'=>"Nom d'affichage de la categorie")) }}
                        <br>
                        Sous-titre de la categorie :
                        {{ Form::text('sub-name', "", array('class' => 'form-control','placeholder'=>"Sous-titre de la categorie")) }}
                        <br>
                        <br>
                        Power de la categorie :
                        {{ Form::text('power', "", array('class' => 'form-control','placeholder'=>"0-10")) }}
                        <br>
                        <br>
                        Sélectionner le serveur de la catégorie :
                        <select name="server" class="form-control select2">
                            <option>Selectionner le serveur</option>
                            <optgroup label="Serveur Principal">
                                @foreach($server as $key => $value)
                                    <option value="{{ $value->_id }}">{{ $value->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>

                        <br>
                        Activer la visibilitée de la categorie sur le site :
                        <br>
                        <br>
                        <input name ="visibility" type="checkbox" checked data-plugin="switchery" data-color="#00b19d"/>
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
