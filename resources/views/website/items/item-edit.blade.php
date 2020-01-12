@extends('layouts.app')
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
                    <h1>Edition de "{{ $Item['name'] }}"</h1>
                    <div class="">
                        {{ Form::model($Item, array('url' => "/website/crud/items/" . $Item['_id'], 'method' => 'PUT','class'=>'form_inline')) }}
                        Nom d'affichage du produit :
                        {{ Form::text('name', $Item['name'],array('class' => 'form-control','placeholder'=>"Nom d'affichage de l'item :")) }}
                        <br>
                        Prix :
                        {{ Form::text('price', $Item['price'],array('class' => 'form-control','placeholder'=>"Valeur de l'item")) }}
                        <br>
                        <br>
                        Nom de la Queue (si ShopLinker) :
                        <br>
                        {{ Form::text('queue',$Item['queue'],array('class' => 'form-control','placeholder'=>"Ex : hub,skyb")) }}

                        <br>
                        <br>
                        Commande (use %player%) :
                        <br>
                        {{ Form::text('command',$Item['command'],array('class' => 'form-control','placeholder'=>"Ex : give %player% 137")) }}
                        <br>
                        Activer le mode item vote :
                        <br>
                        <br>
                        <input name ="vote" type="checkbox" data-plugin="switchery"
                               @if($Item['vote'])
                               checked
                               @endif
                               data-color="#00b19d"/>
                        <br>
                        <br>
                        Pourcentage d'obtention (si vote) :
                        <br>
                        {{ Form::text('vote_percent',$Item['vote_percent'],array('class' => 'form-control','placeholder'=>"Ex : 0-33 33-66 66-100")) }}
                        <br>
                        <br>
                        Description du produit (HTML) :
                        <br>
                        <textarea class="form-control" name="desc"
                                  rows="10" cols="50">
                        </textarea>
                        <br>

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Save</button>

                        {{ Form::close() }}

                        {{ Form::open(array('url' => 'website/crud/items/' . $Item['id'])) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
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

