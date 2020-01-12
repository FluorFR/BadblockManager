@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card-box">
        <h4 class="m-t-0 header-title">Votre profil</h4>
        <div class="row">
          <div class="col-12">
            <div class="p-20">
              {{ Form::open(array('url' => '/profil')) }}
              {!! csrf_field() !!}
              @isset( $error )
                {{ $error }}
              @endisset
              <div class="form-group row">
                <label class="col-2 col-form-label">Votre nouveau mot de passe</label>
                <div class="col-10">
                  <input type="password" class="form-control" placeholder="Nouveau mot de passe" name="password">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-2 col-form-label">Répétez le mot de passe</label>
                <div class="col-10">
                  <input type="password" class="form-control" placeholder="Répétez le mot de passe" name="password_verif">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
