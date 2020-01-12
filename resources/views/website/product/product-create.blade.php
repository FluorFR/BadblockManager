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
                                <h1>Création d'un nouveau produit.</h1>
                            </div>
                        </div>
                    </div>



                    <div class="">
                        {{ Form::open(array('url' => "/website/crud/product" ,'class'=>'form_inline')) }}
                        Nom d'affichage du produit :
                        {{ Form::text('name', "",array('class' => 'form-control','placeholder'=>"Nom d'affichage du produit :")) }}
                        <br>
                        Prix :
                        {{ Form::text('price', "",array('class' => 'form-control','placeholder'=>"Prix du produit")) }}
                        <br>
                        Type :
                        {{ Form::text('mode', "",array('class' => 'form-control','placeholder'=>"rabbitmq")) }}
                        <br>
                        Sélectionner la catégorie :
                        <select name="category" class="form-control select2">
                            <option>Selectionner la catégorie</option>
                            @foreach($cat as $key => $value)
                                <option value="{{ $value->_id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        <br>
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
                        <br>
                        Activer le mode promotion sur ce produit :
                        <br>
                        <br>
                        <input name ="promo" type="checkbox" data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Activer le mode promotion sur ce produit :
                        <br>
                        <br>
                        <input name ="promotion" type="checkbox" data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Pourcentage de promotion :
                        {{ Form::text('promo_coef', "", array('class' => 'form-control','placeholder'=>"50")) }}
                        <br>
                        <br>
                        Nouveau prix de promotion :
                        {{ Form::text('promotion_new_price', "", array('class' => 'form-control','placeholder'=>"50")) }}
                        <br>
                        Visibilité dans le container promotion :
                        <br>
                        <input name ="promotion_view" type="checkbox" data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Nom de la dépendance (si néssecaire) :
                        <br>
                        {{ Form::text('depend_name',"",array('class' => 'form-control','placeholder'=>"Ex : gold")) }}
                        <br>
                        Activer le mode de dépendance sur ce produit :
                        <br>
                        <br>
                        <input name ="depend" type="checkbox" data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Groupe de dépendance :
                        {{ Form::text('depend_to',"",array('class' => 'form-control','placeholder'=>"Nom du group de dépendance")) }}
                        <br>
                        Activer la visibilitée du produit sur le site :
                        <br>
                        <br>
                        <input name ="visibility" type="checkbox" checked data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Image du produit :
                        {{ Form::text('img', "", array('class' => 'form-control','placeholder'=>"URL vers l'image")) }}

                        <br>
                        Description du produit (HTML) :
                        <br>
                        <textarea class="form-control" name="desc"
                                  rows="10" cols="50">
                        </textarea>
                        <br>
                        <br>
                        Item pour boutique Ingame :
                        {{ Form::text('ig_material', "", array('class' => 'form-control','placeholder'=>"")) }}
                        <br>
                        <br>
                        Ingame data :
                        {{ Form::text('ig_data', "", array('class' => 'form-control','placeholder'=>"")) }}
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

