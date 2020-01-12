@extends('layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box">
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
                                    @foreach($buy as $row)
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Rechargement(s) du joueur</h4>
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
                                @foreach($funds as $row)
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
