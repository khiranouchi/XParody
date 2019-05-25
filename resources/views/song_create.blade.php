@extends('layouts.app')

@section('subtitle')
{{ __('labels.subtitle_song_list') }}
@endsection

@section('head')
<link href="{{ asset('css/song_create.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.disableAutoFill.min.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form method="POST" action="{{ route('songs.store') }}" id="song_create_form">
                @csrf
                
                <!-- name_old -->
                <div class="form-group row">
                    <label for="name_old" class="col-sm-4 col-form-label text-sm-right">{{ __('labels.form_song_name_old') }}</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name_old" value="{{ old('name_old') }}" required autofocus>
                    </div>
                </div>
                
                <!-- name_old_ruby -->
                <div class="form-group row">
                    <label for="name_old_ruby" class="col-sm-4 col-form-label text-sm-right">{{ __('labels.form_song_name_old_ruby') }}</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name_old_ruby" value="{{ old('name_old_ruby') }}" required pattern="^[ぁ-んヴー]+$" autofocus>
                    </div>
                </div>
                
                <!-- name_new -->
                <div class="form-group row">
                    <label for="name_new" class="col-sm-4 col-form-label text-sm-right">{{ __('labels.form_song_name_new') }}</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name_new" value="{{ old('name_new') }}" required autofocus>
                    </div>
                </div>
                
                <!-- name_new_ruby -->
                <div class="form-group row">
                    <label for="name_new_ruby" class="col-sm-4 col-form-label text-sm-right">{{ __('labels.form_song_name_new_ruby') }}</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name_new_ruby" value="{{ old('name_new_ruby') }}" required pattern="^[ぁ-んヴー]+$" autofocus>
                    </div>
                </div>
                
                <!-- access_level -->
                <div class="form-group row">
                    <label for="access_level" class="col-sm-4 col-form-label text-sm-right">{{ __('labels.form_song_access_level') }}</label>
                    <div class="col-auto">
                        <select name="access_level" class="form-control">
                            <option value="0" selected>{{ __('labels.value_access_level_0') }}</option>
                            <option value="1">{{ __('labels.value_access_level_1') }}</option>
                            <option value="2">{{ __('labels.value_access_level_2') }}</option>
                            <option value="3">{{ __('labels.value_access_level_3') }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // activate disableAutoFill
    $("#song_create_form").disableAutoFill({
        html5FormValidate: true,
    });
    // re-activate disableAutoFill after submission failed
    // (because disableAutoFill restore original names before submission)
    $("#song_create_form").find('input').on('invalid', function(){
        $("#song_create_form").disableAutoFill({
            html5FormValidate: true
        });
    });
});
</script>
@endsection
