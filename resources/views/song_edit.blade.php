@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form method="PATCH" action="{{ route('songs.update', ['id' => $song]) }}" id="song_update_form">
                @csrf

                <!-- access_level -->
                {{ __('labels.form_song_access_level') }}
                <div class="alert alert-light">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="access_level_0" checked>
                        <label class="form-check-label" for="access_level_0">{{ __('texts.caption_access_level_0') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="access_level_1" checked>
                        <label class="form-check-label" for="access_level_1">{{ __('texts.caption_access_level_1') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="access_level_2" checked>
                        <label class="form-check-label" for="access_level_2">{{ __('texts.caption_access_level_2') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="access_level_3" checked>
                        <label class="form-check-label" for="access_level_3">{{ __('texts.caption_access_level_3') }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
