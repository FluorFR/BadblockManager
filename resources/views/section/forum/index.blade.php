@extends('layouts.app')
@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card-box">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>

                        <h4 class="header-title m-t-0 m-b-30">Tickets Ouverts</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2">
                                <span class="badge badge-success pull-left m-t-20">0% <i class="zmdi zmdi-trending-up"></i> </span>
                                <h2 class="m-b-0"> 0€ </h2>
                                <p class="text-muted m-b-25">Tickets actuellement ouverts</p>
                            </div>
                            <div class="progress progress-bar-success-alt progress-sm m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                     style="width: 77%;">
                                    <span class="sr-only">77% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->


                <div class="col-lg-3 col-md-6">
                    <div class="card-box">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>

                        <h4 class="header-title m-t-0 m-b-30">Topics</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2">
                                <span class="badge badge-success pull-left m-t-20">32% <i class="zmdi zmdi-trending-up"></i> </span>
                                <h2 class="m-b-0"> 0€</h2>
                                <p class="text-muted m-b-25">Topics dans le mois</p>
                            </div>
                            <div class="progress progress-bar-success-alt progress-sm m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                     style="width: 77%;">
                                    <span class="sr-only">77% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-lg-3 col-md-6">
                    <div class="card-box">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>

                        <h4 class="header-title m-t-0 m-b-30">Membres</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2">
                                <span class="badge badge-success pull-left m-t-20">0% <i class="zmdi zmdi-trending-up"></i> </span>
                                <h2 class="m-b-0"> 0</h2>
                                <p class="text-muted m-b-25">Membres de la section</p>
                            </div>
                            <div class="progress progress-bar-success-alt progress-sm m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                     style="width: 100%;">
                                    <span class="sr-only">77% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
                <div class="col-lg-3 col-md-6">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-30">Message staff</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2">
                                    <span class="badge badge-success pull-left m-t-20">0% <i class="zmdi zmdi-trending-up"></i> </span>
                                    <h2 class="m-b-0"> 0</h2>
                                <p class="text-muted m-b-25">Message du staff dans le mois</p>
                            </div>
                            <div class="progress progress-bar-success-alt progress-sm m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 100%;">
                                    <span class="sr-only">77% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div>
            </div>
            </div>
            </div>

@endsection