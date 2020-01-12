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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <h1>Liste des Items  </h1>
                                <a href="/website" id="addToTable" class="btn btn-primary waves-effect waves-light">Retour <i class="fa fa-long-arrow-left"></i></a>
                                <a href="/website/crud/items/create" id="addToTable" class="btn btn-primary waves-effect waves-light">Add <i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <table class="table table-striped" id="datatable-editable">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Valeur</th>
                                <th>Vote</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                               @foreach($Items as $key => $value)
                                   <tr>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->price }}</td>
                                       <td>
                                           @if($value->vote)
                                               <span class="label label-success">Activé</span>
                                           @else
                                               <span class="label label-danger">Désactivé</span>
                                           @endif
                                       </td>
                                       <td>{{ $value->vote_percent }}</td>

                                       <td>
                                            <div>
                                                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
                                                {{ Form::open(array('url' => '/website/crud/items/' . $value->id)) }}
                                                <a class="btn btn-small btn-info" href="{{ URL::to('website/crud/items/' . $value->_id . '/edit') }}">Edit</a>

                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                                {{ Form::close() }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
