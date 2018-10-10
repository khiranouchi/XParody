@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/songio.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<!--  -->
    <div class="x-part">
        <div class="x-subpart">
            <div class="btn-group">
                <button class="btn btn-outline-secondary">{{ __('labels.btn_import') }}</button>
                <button class="btn btn-outline-secondary">{{ __('labels.btn_export') }}</button>
            </div>
        </div>
        <div class="x-subpart">
            <div class="btn-group">
                <button class="btn btn-outline-secondary">{{ __('labels.btn_io_lyrics_old') }}</button>
                <button class="btn btn-outline-secondary">{{ __('labels.btn_io_lyrics_both') }}</button>
                <button class="btn btn-outline-secondary">{{ __('labels.btn_io_lyrics_new') }}</button>
            </div>
        </div>
    </div>

    <!-- Text area -->
    <div class="x-part">
        <textarea id="textarea_import" class="z-import-old z-import-both z-import-new"></textarea>
        <textarea id="textarea_export" class="z-export-old z-export-both z-export-new" readonly></textarea>
	</div>
    
    <!-- Example -->
    <div class="x-part">
        Example: TODO
        <!-- TODO -->
    </div>
    
    <!-- Submit/Copy button -->
    <div class="x-part">
        <button class="z-import-old btn btn-outline-primary"
        >{{ __('labels.btn_import_submit') }}</button>
        <button class="z-import-both btn btn-outline-primary"
        >{{ __('labels.btn_import_submit') }}</button>
        <button class="z-import-new btn btn-outline-primary"
        >{{ __('labels.btn_import_submit') }}</button>
        <button class="z-export-old btn btn-outline-primary"
        >{{ __('labels.btn_export_copy') }}</button>
        <button class="z-export-both btn btn-outline-primary"
        >{{ __('labels.btn_export_copy') }}</button>
        <button class="z-export-new btn btn-outline-primary"
        >{{ __('labels.btn_export_copy') }}</button>        
    </div>
</div>
@endsection
