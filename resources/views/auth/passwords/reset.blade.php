@extends('layout.app')

@section('title')
    Cambiar Contraseña
@endsection

@section('cabecera')
    Nueva Contraseña
@endsection

@section('contenedor')
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/usuarios/passwordactualizada') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} input-field">
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                    <label for="email" class="col-md-4 control-label">Correo:</label>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} input-field">
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                    <label for="password" class="col-md-4 control-label">Nueva contraseña:</label>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} input-field">
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <label for="password-confirm" class="col-md-4 control-label">Confirmar contraseña:</label>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <br/>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn accent-color-dark">
                        Cambiar contraseña
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $('.nav-wrapper').find('ul').remove();
    </script>
@endsection
