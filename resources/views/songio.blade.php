@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/songio.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
<script src="{{ asset('js/songio.js') }}"></script>
@endsection

@section('content')
<div class="container">
	<!--  -->
    <div class="x-part">
        <div class="x-subpart">
            <div class="btn-group">
                <button id="io_import" name="z-import" class="btn btn-outline-secondary"
                        onclick="SwitchMode(this)"
                >{{ __('labels.btn_import') }}</button>
                <button id="io_export" name="z-export" class="btn btn-outline-secondary"
                        onclick="SwitchMode(this)"
                >{{ __('labels.btn_export') }}</button>
            </div>
        </div>
        <div class="x-subpart">
            <div class="btn-group">
                <button id="fmt_old" name="z-lyrics-old" class="btn btn-outline-secondary"
                        onclick="SwitchMode(this)"
                >{{ __('labels.btn_io_lyrics_old') }}</button>
                <button id="fmt_both" name="z-lyrics-both" class="btn btn-outline-secondary"
                        onclick="SwitchMode(this)"
                >{{ __('labels.btn_io_lyrics_both') }}</button>
                <button id="fmt_new" name="z-lyrics-new" class="btn btn-outline-secondary"
                        onclick="SwitchMode(this)"
                >{{ __('labels.btn_io_lyrics_new') }}</button>
            </div>
        </div>
    </div>

    <!-- Text area -->
    <div class="x-part">
        <textarea id="textarea_import" class="z-import"></textarea>
        <div class="z-export">
	        <textarea id="textarea_export_old" class="z-lyrics-old" readonly></textarea>
	        <textarea id="textarea_export_both" class="z-lyrics-both" readonly></textarea>
	        <textarea id="textarea_export_new" class="z-lyrics-new" readonly></textarea>
        </div>
	</div>
    
    <!-- Example -->
    <div class="x-part">
        Example: TODO
        <!-- TODO -->
    </div>
    
    <!-- Submit/Copy button -->
    <div class="x-part">
    	<div class="z-import">
            <button class="z-lyrics-old btn btn-outline-primary"
                    onclick="SaveImportLyrics('textarea_import', '{{ route('songio_import_old', ['id' => $song]) }}')"
            >{{ __('labels.btn_import_submit') }}</button>
            <button class="z-lyrics-both btn btn-outline-primary"
                    onclick="SaveImportLyrics('textarea_import', '{{ route('songio_import_both', ['id' => $song]) }}')"
            >{{ __('labels.btn_import_submit') }}</button>
            <button class="z-lyrics-new btn btn-outline-primary"
            >{{ __('labels.btn_import_submit') }}</button>
        </div>
        <div class="z-export">
            <button class="z-lyrics-old btn btn-outline-primary"
            >{{ __('labels.btn_export_copy') }}</button>
            <button class="z-lyrics-both btn btn-outline-primary"
            >{{ __('labels.btn_export_copy') }}</button>
            <button class="z-lyrics-new btn btn-outline-primary"
            >{{ __('labels.btn_export_copy') }}</button>
        </div>        
    </div>
</div>

<script>
$(document).ready(function(){
    //activate autosize
    autosize($('textarea'));
    // initialize selection (select io_import and fmt_old/fmt_new)
    SwitchMode($('#io_export').get());
    SwitchMode($('#fmt_new').get());
    // initialize export textarea
    LoadExportLyrics('textarea_export_new', '{{ route('songio_export_new', ['id' => $song]) }}');
});
</script>
@endsection
