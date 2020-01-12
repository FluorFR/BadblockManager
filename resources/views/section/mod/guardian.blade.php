@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title">Log gurdian n°{{ $Data->id }}</h4>
                            <br>
                            <div class="card-box">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <h4>
                                                <li>
                                                    Date : {{ $Data->date }}
                                                </li>
                                                <li>
                                                    Type : {{ $Data->type }}
                                                </li>
                                                <li>
                                                    Pseudo : {{ $Data->username }}
                                                </li>
                                                <li>
                                                    Serveur : {{ $Data->serverName }}
                                                </li>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div id="docker" class="form-control" rows="20" disabled="" style="background-color: #000000; height: 400px; overflow-y:scroll;">
                                    {{ $Data->logs }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')

@endsection
