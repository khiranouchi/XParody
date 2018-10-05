@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name (required)') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="icon_char" class="col-md-4 col-form-label text-md-right">{{ __('Icon Character') }}</label>

                            <div class="col-md-6">
                                <input id="icon_char" type="text" class="form-control{{ $errors->has('icon_char') ? ' is-invalid' : '' }}" name="icon_char" value="{{ old('icon_char') }}" autofocus>

                                @if ($errors->has('icon_char'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('icon_char') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="icon_color" class="col-md-4 col-form-label text-md-right">{{ __('Icon Color') }}</label>

                            <div class="col-md-6">
                                <input id="icon_color" type="text" class="form-control{{ $errors->has('icon_color') ? ' is-invalid' : '' }}" name="icon_color" value="{{ old('icon_color') }}" autofocus>

                                @if ($errors->has('icon_color'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('icon_color') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password (required)') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password (required)') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
