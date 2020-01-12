@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box">
      <h4 class="m-t-0 header-title">Liste des avertissements</h4>
      <div class="row">
        <div class="col-12">
          <div class="p-20">
            <table class="table">
              <a class="btn btn-danger" href="/section/avertissement" style="margin-bottom: 1em;">Avertir un joueur</a>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pseudo</th>
                  <th>Avertis par</th>
                  <th>Titre</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach (DB::table('warning')->get() as $key => $data)
                  <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $data->pseudo }}</td>
                    <td>{{ $data->warn_by }}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ \App\Http\Controllers\section\WarningController::convertTime($data->created_at) }}</td>
                    <td><a class="btn btn-success" href="/section/avertissement/{{ $data->id }}" style="margin-right: 10px;">En savoir plus</a><a class="btn btn-danger" href="/section/avertissement/delete/{{ $data->id }}">Supprimer</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <!-- end row -->

    </div> <!-- end card-box -->
  </div><!-- end col -->
</div>
@endsection
