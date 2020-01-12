@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    @section('styles')
    <link href="/assets/css/custom_styles/userprofile.css" rel="stylesheet" type="text/css" />
    @endsection
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <br>
                    <div class="col-lg-2">
                        <div class="card-box">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <img src="https://cdn.badblock.fr/head/{{ $Player['name'] }}/110.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-box">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h4>
                                            Pseudo : {{ $Player['name'] }}
                                            @if(isset($Player['realName']))
                                            <br />
                                            Pseudo réel : {{ $Player['realName'] }}
                                            @endif
                                            <br />
                                            Adresse IP :
                                            @can('profile_ip')
                                                {{ $Player['lastIp'] }}
                                            @endcan
                                            <br />
                                            Mode : {{ $Player['onlineMode'] ? 'premium' : 'cracké' }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-box">
                            <div class="container">
                                <div class="row btn-group" role="group">
                                    <button type="button" class="btn btn-danger btn-lg" onclick="resetPassword()">Reset Password</button>
                                    <button type="button" style="margin-left: 10px" class="btn btn-warning btn-lg" onclick="resetTfa()">Reset TFA</button>
                                </div>
                            </div>
                            <br />
                            <div class="container">
                                <div class="row btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-lg" onclick="resetOm()" >Offline Mode</button>
                                    <button type="button" style="margin-left: 10px" class="btn btn-sucess btn-lg" onclick="resetOl()" >Online Mode</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-xl-12">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="#1" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Skin
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Information G.
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#3" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                Casier
                                            </a>
                                        </li>
                                        @can('profile_guardian')
                                        <li class="nav-item">
                                            <a href="#4" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Logs Guardian
                                            </a>
                                        </li>
                                        @endcan
                                        @can('profile_achat')
                                        <li class="nav-item">
                                            <a href="#5" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Achats
                                            </a>
                                        </li>
                                        @endcan
                                        @can('profile_fund')
                                        <li class="nav-item">
                                            <a href="#6" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Paiements
                                            </a>
                                        </li>
                                        @endcan
                                        @can('profile_grade')
                                        <li class="nav-item">
                                            <a href="#7" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Groupes & Permissions
                                            </a>
                                        </li>
                                        @endcan
                                        @can('profile_auth')
                                        <li class="nav-item">
                                            <a href="#8" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Authentification
                                            </a>
                                        </li>
                                        @endcan
                                        <li class="nav-item">
                                            <a href="#9" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Logs
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade" id="1">
                                            <img src="https://minotar.net/body/{{ str_replace('-', '', $Player['uniqueId']) }}/150.png">
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="2">
                                            <div class="container">
                                                <table class="table userinfotable">
                                                    <tr>
                                                        <th>Nom :</th>
                                                        <td>{{ $Player['name'] }}</td>
                                                    </tr>
                                                    @if(isset($Player['realName']))
                                                        <tr>
                                                            <th>Nom réel :</th>
                                                            <td class="color-brighter">{{ $Player['realName'] }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Adresse IP :</th>
                                                        <td class="color-brighter">
                                                            @can('profile_ip')
                                                                {{ $Player['lastIp'] }}
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Groupe(s) secondaire(s) :</th>
                                                        <td>
                                                            <ul class="in-table-list">
                                                            @foreach($Player['permissions']['groups'] as $k => $row)
                                                            <li class="color-brighter">
                                                                {{ $k }}
                                                                <ul class="in-table-list">
                                                                    @foreach($row as $p => $h)
                                                                        <li class="color-brighter">
                                                                            Groupe : {{ $p }} - Time : {{ $h }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Niveau :</th>
                                                        <td class="color-brighter">{{ $Player['game']['level'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Xp :</th>
                                                        <td class="color-brighter">{{ $Player['game']['xp'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Badcoins :</th>
                                                        <td class="color-brighter">{{ $Player['game']['badcoins'] }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="3">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Banner</th>
                                                    <th>Début / Fin</th>
                                                    <th>Raison</th>
                                                    <th>Details</th>
                                                </tr>
                                                </thead>
                                                <tbody id="sanction_list">
                                                @foreach($Sanctions as $row)
                                                    <tr>
                                                        <td>{{ $row['uuid'] }}</td>
                                                        <td>{{ $row['type'] }}</td>
                                                        <td>{{ $row['punisher'] }}</td>
                                                        <td>
                                                            {{ date('d-m-Y', $row['timestamp'] / 1000) }} /
                                                        @if($row['expire'] == -1)
                                                                Infinis
                                                            @else
                                                                {{ date('d-m-Y', $row['expire'] / 1000) }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $row['reason'] }}</td>
                                                        <td>
                                                            @if(!is_array($row['proof']))
                                                                <a onClick="window.open('/moderation/preuve/{{ $row['proof'] }}','Sanctions','resizable,height=450,width=700'); return false;" class="btn btn-icon waves-effect waves-light btn-info m-b-5">
                                                                    <i class="fa fa-eye"></i> </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="4">
                                            <h4 class="header-title m-t-0 m-b-30">Logs guardian du joueur</h4>
                                            <table class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Nom du serveur</th>
                                                    <th>Cheat</th>
                                                    <th>Type</th>
                                                    <th>#</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @can('profile_guardian')
                                                @foreach($Guardian as $row)
                                                    <tr>
                                                        <th scope="row">{{ $row->date }}</th>
                                                        <td>{{ $row->serverName }}</td>
                                                        <td>{{ $row->cheat }}</td>
                                                        <td>{{ $row->type }}</td>
                                                        <td>
                                                            <a target="_blank" href="/moderation/guardian/{{ $row->id }}" class="btn btn-icon waves-effect waves-light btn-info m-b-5">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endcan
                                                </tbody>
                                            </table>

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="5">
                                            <h4 class="header-title m-t-0 m-b-30">Achat(s) du joueur</h4>
                                            <table class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Offre</th>
                                                    <th>Points</th>
                                                    <th>Ingame</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @can('profile_achat')
                                                    @foreach($Player['buy'] as $row)
                                                        <tr>
                                                            <th scope="row">{{ $row['date'] }}</th>
                                                            <td>{{ $row['name'] }}</td>
                                                            <td>{{ $row['price'] }}</td>
                                                            <td>
                                                                @if($row['ingame'])
                                                                    <i class="fa fa-check"></i>
                                                                @else
                                                                    <i class="fa fa-remove"></i>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endcan
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="6">
                                            <div class="card-box">
                                                <h4 class="header-title m-t-0 m-b-30">Rechargement(s) du joueur / Solde {{ $Player["shop"] }}</h4>
                                                <table class="table">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Gateway</th>
                                                        <th>Prix</th>
                                                        <th>Points</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @can('profile_fund')

                                                        @foreach($Player['funds'] as $row)
                                                        <tr>
                                                            <th scope="row">{{ $row['date'] }}</th>
                                                            <td>{{ $row['gateway'] }}</td>
                                                            <td>{{ $row['price'] }}</td>
                                                            <td>{{ $row['points'] }}</td>
                                                            <td>
                                                                <a target="_blank" href="https://badblock.fr/dashboard/facture/{{ $row['_id'] }}" class="btn btn-icon waves-effect waves-light btn-info m-b-5">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                        @endcan
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="7">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h4>Groupes</h4>
                                                    <ul>
                                                        @foreach($Player['permissions']['groups'] as $place => $groups)
                                                            <li>
                                                                {{ $place }}
                                                                <ul>
                                                                    @foreach($groups as $name => $timestamp)
                                                                        <li>
                                                                            {{ $name }} {{ $timestamp > 0  ? '- expire le ' . date('d/m à H:i', time()) : '- à vie' }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <h4>Permissions</h4>
                                                    <ul>
                                                        @forelse($Player['permissions']['permissions'] as $place => $permissions)
                                                            <li>
                                                                {{ $place }}
                                                                <ul>
                                                                    @foreach($permissions as $name => $timestamp)
                                                                        <li>
                                                                            {{ $name }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @empty
                                                            Aucune permission
                                                        @endforelse
                                                    </ul>
                                                </div>
                                                <div class="col-md-8">
                                                    <form id="addGroupForm">
                                                        <h4>Ajouter un groupe</h4>
                                                        <div class="form-group">
                                                            <label for="groupPlaceInput">Place</label>
                                                            <select name="group-place" id="groupPlaceInput"
                                                                    class="form-control">
                                                                @foreach($Places as $place)
                                                                    <option value="{{ $place }}">{{ $place }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="groupPlaceInput">Groupe</label>
                                                            <select name="group-place" id="groupNameInput"
                                                                    class="form-control">
                                                                @foreach($AvailablePermissions as $permission)
                                                                    <option value="{{ $permission['name'] }}">{{ $permission['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="groupExpireInput">Expiration</label>
                                                            <small>Si aucune expiration laisser vide</small>
                                                            <input id="groupExpireInput" type="date" value="" class="form-control">
                                                        </div>
                                                        <button role="submit" class="btn btn-info">Ajouter</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h3>10 dernières connexions</h3>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Adresse IP</th>
                                                        </tr>
                                                        @foreach($ConnectionLogs as $log)
                                                        <tr>
                                                            <td>{{ date('d/m/Y à H:i', strtotime($log['date'])) }}</td>
                                                            <td>{{ $log['lastIp'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    <ul class="color-brighter">
                                                        <!-- Online mode -->
                                                        @if($Player['onlineMode'])
                                                        <li>L'utilisateur est premium</li>
                                                        @else
                                                        <li>L'utilisateur n'est pas premium</li>
                                                        @endif
                                                        <!-- Password -->
                                                        @if(empty($Player['loginPassword']))
                                                            <li>L'utilisateur n'a pas défini de mot de passe à la connexion</li>
                                                        @else
                                                            <li>L'utilisateur a définit un mot de passe</li>
                                                        @endif
                                                        <!-- Auth key -->
                                                        @if(!isset($Player['authKey']) || empty($Player['authKey']))
                                                            <li>L'utilisateur n'a pas de clé d'authentification</li>
                                                        @else
                                                            <li>Clé d'authentification : {{ $Player['authKey'] }}</li>
                                                        @endif
                                                    </ul>
                                                    <div class="row auth-buttons">
                                                        <button type="button" class="btn btn-danger btn-lg" onclick="resetPassword()">Reset Password</button>
                                                        <button type="button" class="btn btn-warning btn-lg" onclick="resetTfa()">Reset TFA</button>
                                                        <button type="button" class="btn btn-info btn-lg" onclick="resetOm()" >Offline Mode</button>
                                                        <button type="button" class="btn btn-sucess btn-lg" onclick="resetOl()" >Online Mode</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="9">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Utilisateur</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($Logs as $Log)
                                                    <tr
                                                    @if($Log['action'] == "Actived online mode")
                                                    class="bg-success text-white"
                                                    @elseif($Log['action'] == "Actived offline mode")
                                                    class="bg-warning text-white"
                                                    @else
                                                    class="bg-danger text-white"
                                                    @endif
                                                    >
                                                        <td>{{ $Log['date'] }}</td>
                                                        <td>{{ $Log['user'] }}</td>
                                                        <td>{{ $Log['action'] }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        
        function resetPassword() {
            $.ajax({
                type: "POST",
                url: "/profile-api/{{ $Player['uniqueId'] }}/resetpassword",
                success:function(data)
                {
                    toastr.success('Succès !', "Le mot de passe à bien était reset !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Erreur !', 'Un problème s\'est produit ou vos permissions sont insuffisantes !');
                    console.log('Erreur !');
                }
            });
        }
        
        function resetTfa() {
            $.ajax({
                type: "POST",
                url: "/profile-api/{{ $Player['uniqueId'] }}/resettfa",
                success:function(data)
                {
                    toastr.success('Succès !', "La TFA est bien désactivée !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Erreur !', 'Un problème s\'est produit ou vos permissions sont insuffisantes !');
                    console.log('Erreur !');
                }
            });
        }
        
        function resetOm() {
            $.ajax({
                type: "POST",
                url: "/profile-api/{{ $Player['uniqueId'] }}/resetom",
                success:function(data)
                {
                    toastr.success('Succès !', "L'offline mode est activé !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Erreur !', 'Un problème s\'est produit ou vos permissions sont insuffisantes !');
                    console.log('Erreur !');
                }
            });
        }

        function resetOl() {
            $.ajax({
                type: "POST",
                url: "/profile-api/{{ $Player['uniqueId'] }}/resetol",
                success:function(data)
                {
                    toastr.success('Succès !', "L'online est activé !");
                    console.log('Valider !');
                },
                error:function(data)
                {
                    toastr.error('Erreur !', 'Un problème s\'est produit ou vos permissions sont insuffisantes !');
                    console.log('Erreur !');
                }
            });
        }

        /*
            Modal 7: Groupes & permissions
         */
        $(document).ready(function() {
            $('#addGroupForm button[role="submit"]').click(function(event) {
               event.preventDefault();
               const $button = $(event.target);
               $button.prop('disabled', true);
               $button.toggleClass('disabled');
               const placeInput = $('#groupPlaceInput');
               const groupeInput = $('#groupNameInput');
               const expireInput = $('#groupExpireInput');

               $.post("/profile-api/{{ $Player['uniqueId'] }}/addgroup", {
                   place: placeInput.val(),
                   group: groupeInput.val(),
                   expire: expireInput.val(),
               }, function(response) {
                   if(response && response.success) {
                       toastr.success(response.message);
                   }
                   $button.prop('disabled', false);
                   $button.toggleClass('disabled');
               }, 'json');
            })
        });


        /*
            Remember last active tab
         */
        $(document).ready(function( ) {
            const hash = document.location.hash;
            if(hash.match(/#[0-9]+/)) {
                $('.nav-item a[href="' + hash + '"]').tab('show');
            } else {
                // Show skin tab by default
                $('.nav-item a[href="#2"]').tab('show');
            }
        })
        
    </script>
    

@endsection
