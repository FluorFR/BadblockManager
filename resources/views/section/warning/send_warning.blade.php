@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box">
      <h4 class="m-t-0 header-title">Envoyer un avertissement</h4>
      <div class="row">
        <div class="col-12">
          <div class="p-20">
            <form class="form-horizontal" method="POST" action="{!! url('/section/avertissement') !!}" accept-charset="UTF-8">
              {!! csrf_field() !!}
              <input type="hidden" name="warn_by" value="{{ Auth::user()->name }}">
              <div class="form-group row">
                <label class="col-2 col-form-label">Titre</label>
                <div class="col-10">
                  <input type="text" class="form-control" placeholder="Titre" name="title">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-2 col-form-label">Envoyer à</label>
                <div class="col-10">
                  <input type="text" class="form-control" placeholder="Pseudo" name="pseudo">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-2 col-form-label">Texte</label>
                <div class="col-10">
                  <textarea class="form-control" rows="5" name="text"></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
          </div>
        </div>

      </div>
      <!-- end row -->

    </div> <!-- end card-box -->
  </div><!-- end col -->
</div>
@endsection
