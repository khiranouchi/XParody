@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/song.css') }}" rel="stylesheet">
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
                        <dd class="col-sm-10">{{ $song->name_new }} ({{ $song->name_new_ruby }})</dd>
                        <dt class="col-sm-2">{{ __('labels.song_name_old') }}</dt>
                        <dd class="col-sm-10">{{ $song->name_old }} ({{ $song->name_old_ruby }})</dd>
                        <dt class="col-sm-2">{{ __('labels.song_updated_time') }}</dt>
                        <dd class="col-sm-10">{{ $song->getUpdatedAtDate() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Song editor -->
    <div class="x-part row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Each lyrics-box --> <!-- TODO -->
            <div class="x-lyrics-box">
                <!-- lyrics-old -->
                <div class="x-lyrics-old">
                    <div class="x-lyrics-text">Old lyrics goes like this...</div>
                </div>
                <div class="x-lyrics-new x-row-margin-reset row">
                    <div class="x-lyrics-text">New lyrics 1</div>
                    <div class="x-lyrics-level">5</div>
                    <div class="x-lyrics-user d-flex align-items-center"><span>G</span></div>
                </div>
                <div class="x-lyrics-new">(+new)</div>
            </div>
            <!-- Each lyrics-box --> <!-- TODO -->
            <div class="x-lyrics-box">
                <!-- lyrics-old -->
                <div class="x-lyrics-old">
                    <div class="x-lyrics-text">Old lyrics goes like this...</div>
                </div>
                <!-- lyrics-new -->
                <div class="x-lyrics-new">(+new)</div>
            </div>
        </div>
    </div>
</div>
@endsection
