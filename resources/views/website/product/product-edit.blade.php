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
                    <h1>Edition de {{ $Product['name'] }}</h1>
                    <div class="">
                        {{ Form::model($Product, array('url' => "/website/crud/product/" . $Product['id'], 'method' => 'PUT','class'=>'form_inline')) }}
                        Nom d'affichage du produit :
                        {{ Form::text('name', $Product['name'], array('class' => 'form-control','placeholder'=>"Nom d'affichage du produit :")) }}
                        <br>
                        Prix :
                        {{ Form::text('price', $Product['price'], array('class' => 'form-control','placeholder'=>"Prix du produit")) }}
                        <br>
                        Type de livraison :
                        {{ Form::text('mode', $Product['mode'],array('class' => 'form-control','placeholder'=>"Type du produit")) }}
                        <br>
                        Sélectionner la catégorie :
                        <select name="category" class="form-control select2">
                            @foreach($cat as $key => $value)
                                @if($Product['cat_id'] == $value->_id)
                                    <option value="{{ $value->_id }}" selected>{{ $value->name }}</option>
                                @else
                                    <option value="{{ $value->_id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                        <br>
                        Nom de la Queue (si ShopLinker) :
                        <br>
                        {{ Form::text('queue',$Product['queue'],array('class' => 'form-control','placeholder'=>"Ex : hub,skyb")) }}

                        <br>
                        <br>
                        Commande (use %player%) :
                        <br>
                        {{ Form::text('command',$Product['command'],array('class' => 'form-control','placeholder'=>"Ex : give %player% 137")) }}
                        <br>
                        <br>
                        Activer le mode promotion sur ce produit :
                        <br>
                        <br>
                        <input name ="promotion" type="checkbox"
                               @if($Product['promotion'])
                               checked
                               @endif
                               data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Pourcentage de promotion :
                        {{ Form::text('promo_coef', $Product['promo_coef'], array('class' => 'form-control','placeholder'=>"50%")) }}
                        <br>
                        <br>
                        Nouveau prix de promotion :
                        {{ Form::text('promotion_new_price', $Product['promotion_new_price'], array('class' => 'form-control','placeholder'=>"50%")) }}
                        <br>
                        Visibilité dans le container promotion :
                        <br>
                        <input name ="promotion_view" type="checkbox"
                               @if($Product['promotion_view'])
                               checked
                               @endif
                               data-plugin="switchery" data-color="#00b19d"/>
                        <br>
                        <br>
                        Nom de la dépendance (si néssecaire) :
                        <br>
                        {{ Form::text('depend_name',"",array('class' => 'form-control','placeholder'=>"Ex : gold")) }}
                        <br>
                        <br>
                        Activer le mode de dépendance sur ce produit :
                        <br>
                        <br>
                        <input name ="depend" type="checkbox" data-plugin="switchery"
                               @if($Product['depend'])
                        checked
                               @endif
                               data-color="#00b19d"/>
                        <br>
                        <br>
                        Id de dépendance :
                        {{ Form::text('depend_to',$Product['depend_to'],array('class' => 'form-control','placeholder'=>"Nom du group de dépendance")) }}
                        <br>

                        <br>
                        Nom unique de dépendance :
                        {{ Form::text('depend_name',$Product['depend_name'],array('class' => 'form-control','placeholder'=>"Nom du group de dépendance")) }}
                        <br>

                        Activer la visibilitée du produit sur le site :
                        <br>
                        <br>
                        <input name ="visibility" type="checkbox"
                               @if($Product['visibility'])
                                checked
                               @endif

                        data-plugin="switchery" data-color="#00b19d"/>

                        <br>
                        <br>
                        Image du produit :
                        {{ Form::text('image', $Product['image'], array('class' => 'form-control','placeholder'=>"URL vers l'image")) }}
                        <br>
                        Description du produit (HTML) :
                        <br>
                        <textarea class="form-control" name="desc"
                                  rows="10" cols="50">{{ $Product['description'] }}
                        </textarea>
                        <br>

                        <br>
                        Item pour boutique Ingame :
                        {{ Form::text('ig_item', $Product['ig_material'], array('class' => 'form-control','placeholder'=>"")) }}
                        <br>
                        <br>
                        Ingame data :
                        {{ Form::text('ig_data', $Product['ig_data'], array('class' => 'form-control','placeholder'=>"")) }}
                        <br>

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Save</button>
                        {{ Form::close() }}

                        {{ Form::open(array('url' => 'website/crud/Product/' . $Product['id'])) }}
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

