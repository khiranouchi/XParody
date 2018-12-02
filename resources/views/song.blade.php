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
                        <!-- Name new -->
                        <dt class="col-sm-2">{{ __('labels.song_name_new') }}</dt>
                        <dd class="col-sm-10">
                            <span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new', false)"
                            >{{ $song->name_new }}</span>
                            (<span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new_ruby', false)"
                            >{{ $song->name_new_ruby }}</span>)
                        </dd>
                        <!-- Name old -->
                        <dt class="col-sm-2">{{ __('labels.song_name_old') }}</dt>
                        <dd class="col-sm-10">
                            <span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old', false)"
                            >{{ $song->name_old }}</span>
                            (<span onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old_ruby', false)"
                            >{{ $song->name_old_ruby }}</span>)
                        </dd>
                        <!-- Updated time -->
                        <dt class="col-sm-2">{{ __('labels.song_updated_time') }}</dt>
                        <dd class="col-sm-10
                                   @if ($song->is_complete)
                                   text-success
                                   @endif
                        ">{{ $song->getUpdatedAtDateTime() }}</dd>
                        <!-- Buttons -->
                        <dd class="col-sm-12">
                            <!-- Set is_complete flag on -->
                            <form action="{{ route('songs.update', ['id' => $song]) }}" method="post"
                                  @if ($song->is_complete)
                                  onsubmit="ShowCheckDialog(event, '{{ __('labels.dialog_restart_song') }}')"
                                  @else
                                  onsubmit="ShowCheckDialog(event, '{{ __('labels.dialog_complete_song') }}')"
                                  @endif
                                  class="x-inline-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_complete"
                                       @if ($song->is_complete)
                                       value="0">
                                       @else
                                       value="1">
                                       @endif
                                <button type="submit" class="btn btn-outline-secondary x-btn-small-padding">
                                    @if ($song->is_complete)
                                    {{ __('labels.btn_restart_song') }}
                                    @else
                                    {{ __('labels.btn_complete_song') }}
                                    @endif
                                </button>
                            </form>
                            <!-- Update updated-time -->
                            @if (!$song->is_complete)
                            <form action="" method="post"
                                  onsubmit="ShowCheckDialog(event, '{{ __('labels.dialog_update_song_time') }}')"
                                  class="x-inline-form">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-outline-secondary x-btn-small-padding">
                                    {{ __('labels.btn_update_song_time') }}
                                </button>
                            </form>
                            @endif
                        </dd>
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
