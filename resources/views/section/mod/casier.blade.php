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
                            <h4 class="m-t-0 header-title">Sanction de {{ $pseudo }}</h4>
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
                                    @foreach($sanction as $row)
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')

@endsection
