@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/song.css') }}" rel="stylesheet">
<script src="{{ asset('js/all.js') }}"></script>
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
            @foreach ($lyrics_boxes as $lyrics_box)
            <div class="x-lyrics-box">
                <!-- lyrics-old -->
                <div class="x-lyrics-old">
                    <div class="x-lyrics-text"
                         onclick="SwitchInputMode(this, '{{ route('lyrics_boxs.update', ['id' => $lyrics_box]) }}', 'lyrics_old')"
                    >{{ $lyrics_box->lyrics_old }}</div>
                </div>
                <!-- lyrics-new -->
                @foreach ($dict_lyrics_box_lines[$lyrics_box->box_idx] as $lyrics_box_line)
                <div class="x-lyrics-new x-row-margin-reset row">
                    <div class="x-lyrics-text">{{ $lyrics_box_line->lyrics_new }}</div>
                    <div class="x-lyrics-level">{{ $lyrics_box_line->level }}</div>
                    <div class="x-lyrics-user d-flex align-items-center"><span>{{ $lyrics_box_line->user_id }}</span></div>
                </div>
                @endforeach
                <div class="x-lyrics-new">(+new)</div>
            </div>
            @endforeach
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
