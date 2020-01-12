@extends('layouts.app')

@section('content')
    <div class="account-pages"></div>
    <div class="clearfix"></div>
    <div class="container-fluid">
        <div class="wrapper-page">
            <div class="text-center">
                <h1 class="text-muted m-t-0 font-600">BadBlock</h1>
                <h5 class="text-muted m-t-0 font-600">Admin - Manager</h5>
            </div>
            <div class="m-t-40 card-box">
                <div class="panel-body">
                    <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" required="" value="{{ old('email') }}" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-custom">
                                    <input id="checkbox-signup" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-30">
                            <div class="col-xs-12">
                                <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Connection</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12">
                                <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Mot de passe oublié ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper page -->
@endsection
