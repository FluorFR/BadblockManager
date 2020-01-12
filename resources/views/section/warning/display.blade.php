@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box">
      @foreach ($user as $key => $data)
      <h4 class="m-t-0 header-title">Avertissement de {{ $data->pseudo }}</h4>
      <div class="row">
        <div class="col-12">
          <br />
          <p>Date : {{ \App\Http\Controllers\section\WarningController::convertTime($data->created_at) }}</p>
          <p>Avertis par : <span class="text-success">{{ $data->warn_by }}</span></p>
          Raison :
          <br />
          {{ $data->text }}
          <div class="p-20">
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
