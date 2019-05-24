@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/songh.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="x-part">
        Edit History
        <div class="alert alert-light">
            <!-- History of create song -->
            <div class="row x-row-margin-reset">
                <!-- Time -->
                <div>{{ $song->getCreatedAtDateTime() }}</div>

                <!-- User -->
                @if (isset($song->creator_user))
                <div class="x-user-icon d-flex align-items-center"
                     style="background-color:{{ $song->creator_user->getIconColorRgbString() }}">
                    <span>{{ $song->creator_user->icon_char }}</span>
                </div>
                @else
                <div class="x-user-empty"></div>
                @endif

                <!-- Edit type -->
                <div class="x-edit-type">{{ __('labels.value_edit_type_song_created') }}</div>
            </div>

            <!-- Histories of edit song -->
            @foreach ($edit_histories as $edit_history)
            <div class="row x-row-margin-reset">
                <!-- Time -->
                <div>{{ $edit_history->getCreatedAtDateTime() }}</div>

                <!-- User -->
                @if (isset($edit_history->user))
                <div class="x-user-icon d-flex align-items-center"
                     style="background-color:{{ $edit_history->user->getIconColorRgbString() }}">
                    <span>{{ $edit_history->user->icon_char }}</span>
                </div>
                @else
                <div class="x-user-empty"></div>
                @endif

                <!-- Edit type -->
                <div class="x-edit-type">{{ __('labels.'.$edit_history->getEditTypeLabel()) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
