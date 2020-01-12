@extends('layouts.app')
@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <div class="row">

                        <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <h1>Création d'un nouveau Item :</h1>
                            </div>
                        </div>
                    </div>



                    <div class="">
                        {{ Form::open(array('url' => "/website/crud/items" ,'class'=>'form_inline')) }}
                        Nom d'affichage du produit :
                        {{ Form::text('name', "",array('class' => 'form-control','placeholder'=>"Nom d'affichage de l'item :")) }}
                        <br>
                        Prix :
                        {{ Form::text('price', "",array('class' => 'form-control','placeholder'=>"Valeur de l'item")) }}
                        <br>
                        <br>
                        Nom de la Queue (si ShopLinker) :
                        <br>
                        {{ Form::text('queue',"",array('class' => 'form-control','placeholder'=>"Ex : hub,skyb")) }}

                        <br>
                        <br>
                        Commande (use %player%) :
                        <br>
                        {{ Form::text('command',"",array('class' => 'form-control','placeholder'=>"Ex : give %player% 137")) }}
                        <br>
                        Activer le mode item vote :
                        <br>
                        <br>
                        <input name ="vote" type="checkbox" checked data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        Pourcentage d'obtention (si vote) :
                        <br>
                        {{ Form::text('vote_percent',"",array('class' => 'form-control','placeholder'=>"Ex : 0-33 33-66 66-100")) }}
                        <br>
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
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <footer class="footer text-right">
        2017 - 2018 © BadBlock.
    </footer>
    </div>


    <script>
        var resizefunc = [];
    </script>


@endsection

