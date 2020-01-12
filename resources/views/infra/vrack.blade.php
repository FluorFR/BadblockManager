@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <center> <h1>DDNS Vrack</h1> </center>
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                            </div>
                        </div>
                        <h4 class="m-t-0 header-title">Liste des DDNS de Badblock</h4>

                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Domain</th>
                                <th>IP Dest</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($hosts as $k => $host)
                                <tr>
                                    <th scope="row">{{ $k }}</th>
                                    <td>{{ $host }}.badblock-network.fr</td>
                                    <td>{{ $ips[$k] }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="bat('{{ $host }}')">BAT</button>
                                        <button type="button" class="btn btn-warning" onclick="update('{{ $host }}')">Set</button>
                                        <button type="button" class="btn btn-defualt" onclick="disable('{{ $host }}')">Disable</button>
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
@endsection
@section('after_scripts')
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        function update(dns) {
            $.ajax({
                type: "GET",
                url: "/infra/vrack-update/" + dns,
                success:function(data)
                {
                    toastr.success('Le DDNS à était mis à jour avec votre IP', "Succès !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Un problème s\'est produit ou vos permissions sont insuffisantes ou Cloudfare refuse !', 'Erreur !');
                    console.log('Erreur !');
                }
            });
        }


        function disable(dns) {
            $.ajax({
                type: "GET",
                url: "/infra/vrack-down/" + dns,
                success:function(data)
                {
                    toastr.success('Le DDNS à était désactivé !', "Succès !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Un problème s\'est produit ou vos permissions sont insuffisantes ou Cloudfare refuse !', 'Erreur !');
                    console.log('Erreur !');
                }
            });
        }

        function bat(dns) {
            window.location = '/infra/vrack-bat/' + dns;
        }
    </script>


@endsection
