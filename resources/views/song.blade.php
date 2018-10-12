@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/song.css') }}" rel="stylesheet">
<script src="{{ asset('js/all.js') }}"></script>
<script src="{{ asset('js/song.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <!-- Song info -->
    <div class="x-part row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-2">{{ __('labels.song_name_new') }}</dt>
                        <dd class="col-sm-10">
                            <span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new', false)"
                            >{{ $song->name_new }}</span>
                            (<span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new_ruby', false)"
                            >{{ $song->name_new_ruby }}</span>)
                        </dd>
                        <dt class="col-sm-2">{{ __('labels.song_name_old') }}</dt>
                        <dd class="col-sm-10">
                            <span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old', false)"
                            >{{ $song->name_old }}</span>
                            (<span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old_ruby', false)"
                            >{{ $song->name_old_ruby }}</span>)
                        </dd>
                        <dt class="col-sm-2">{{ __('labels.song_updated_time') }}</dt>
                        <dd class="col-sm-10">{{ $song->getUpdatedAtDateTime() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Song editor -->
    <div class="x-part row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	@include('song.lyrics_boxes')
        </div>
    </div>
    
    <!-- Buttons -->
    <div class="x-part x-button-row">
        <!-- Delete song -->
        <form action="{{ route('songs.destroy', ['id' => $song]) }}" method="post"
              onsubmit="ShowCheckDialog(event, '{{ __('labels.dialog_delete_song') }}')"
              class="x-inline-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                {{ __('labels.btn_delete_song') }}
            </button>
        </form>
        <!-- Import and Export -->
        <button onclick="location.href='{{ route('songio', ['id' => $song]) }}'"
                class="btn btn-outline-primary">
            {{ __('labels.btn_import_and_export') }}
        </button>
    </div>
</div>
@endsection
