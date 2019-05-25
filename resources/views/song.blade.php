@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/song.css') }}" rel="stylesheet">
<script src="{{ asset('js/song.js') }}"></script>
@endsection

@section('content')
<div class="container x-container-ds">
    <!-- Song info -->
    <div class="x-part row x-row-ds">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 x-col-ds">
            <div class="card">
                <div class="card-body">
                    <dl class="row x-row-ds">
                        <!-- Name new -->
                        <dt class="col-sm-2 x-col-ds">{{ __('labels.song_name_new') }}</dt>
                        <dd class="col-sm-10 x-col-ds">
                            <span
                                @if ($song->isAccessible($request_user_id, 1))
                                onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new', false)"
                                @endif
                            >{{ $song->name_new }}</span>
                            (<span
                                @if ($song->isAccessible($request_user_id, 1))
                                onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_new_ruby', false)"
                                @endif
                            >{{ $song->name_new_ruby }}</span>)
                        </dd>

                        <!-- Name old -->
                        <dt class="col-sm-2 x-col-ds">{{ __('labels.song_name_old') }}</dt>
                        <dd class="col-sm-10 x-col-ds">
                            <span
                                @if ($song->isAccessible($request_user_id, 1))
                                onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old', false)"
                                @endif
                            >{{ $song->name_old }}</span>
                            (<span
                                @if ($song->isAccessible($request_user_id, 1))
                                onclick="SwitchInputMode(this, '{{ route('songs.update', ['id' => $song]) }}', 'name_old_ruby', false)"
                                @endif
                            >{{ $song->name_old_ruby }}</span>)
                            @if (!isset($song->access_level) or $song->access_level === 0 or !isset($song->creator_user))
                            @elseif ($request_user_id === $song->creator_user_id)
                            <span class="text-primary">({{ $song->access_level }})</span>
                            @else
                            <span class="text-danger">({{ $song->access_level }})</span>
                            @endif
                        </dd>

                        <!-- Updated time -->
                        <dt class="col-sm-2 x-col-ds">{{ __('labels.song_updated_time') }}</dt>
                        <dd class="col-sm-10 x-col-ds
                                   @if ($song->is_complete)
                                   text-success
                                   @endif">
                            <div class="row x-row-margin-reset">
                                <div>{{ $song->getUpdatedAtDateTime() }}</div>
                                @if (isset($latest_edit))
                                <div class="x-lyrics-user d-flex align-items-center x-cursor-pointer"
                                     style="background-color:{{ $latest_edit->user->getIconColorRgbString() }}"
                                     onclick="location.href='{{ route('songh', ['id' => $song]) }}'">
                                    <span>{{ $latest_edit->user->icon_char }}</span>
                                </div>
                                @elseif (isset($song->creator_user))
                                <div class="x-lyrics-user d-flex align-items-center x-cursor-pointer"
                                     style="background-color:{{ $song->creator_user->getIconColorRgbString() }}"
                                     onclick="location.href='{{ route('songh', ['id' => $song]) }}'">
                                    <span>{{ $song->creator_user->icon_char }}</span>
                                </div>
                                @endif
                            </div>
                        </dd>

                        <!-- Buttons -->
                        @if ($song->isAccessible($request_user_id, 1))
                        <dd class="col-sm-12 x-col-ds">
                            <!-- Complete / Restart edit -->
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
                            <!-- Edit song -->
                            @if (isset($song->creator_user) and $request_user_id === $song->creator_user->id)
                            <button onclick="location.href='{{ route('songs.edit', ['id' => $song]) }}'"
                                    class="btn btn-outline-secondary x-btn-small-padding">
                                {{ __('labels.btn_edit_song') }}
                            </button>
                            @endif
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Song editor -->
    <div class="x-part row x-row-ds">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 x-col-ds">
        	@include('song.lyrics_boxes')
        </div>
    </div>
    
    <!-- Buttons -->
    <div class="x-part x-button-row">
        <!-- Delete song -->
        @if ($song->isAccessible($request_user_id, 1))
        <form action="{{ route('songs.destroy', ['id' => $song]) }}" method="post"
              onsubmit="ShowCheckDialogWithDate(event, '{{ __('labels.dialog_delete_song') }}')"
              class="x-inline-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                {{ __('labels.btn_delete_song') }}
            </button>
        </form>
        @endif
        <!-- Import and Export -->
        <button onclick="location.href='{{ route('songio', ['id' => $song]) }}'"
                class="btn btn-outline-primary">
            {{ __('labels.btn_import_and_export') }}
        </button>
    </div>
</div>
@endsection
