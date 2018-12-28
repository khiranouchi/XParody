@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('head')
<link href="{{ asset('css/songio.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
<script src="{{ asset('js/jquery.clipboard.min.js') }}"></script>
<script src="{{ asset('js/songio.js') }}"></script>
@endsection

@section('content')
<div class="container">
	<!-- Modes -->
    <div class="x-part">
        <div class="x-subpart">
            <div class="btn-group">
                @if (!$song->is_complete)
                <button id="io_import" name="z-import" class="btn btn-outline-secondary"
                        onclick="SwitchVisibility(this)"
                >{{ __('labels.btn_import') }}</button>
                @endif
                <button id="io_export" name="z-export" class="btn btn-outline-secondary"
                        onclick="SwitchVisibility(this)"
                >{{ __('labels.btn_export') }}</button>
            </div>
        </div>
        <div class="x-subpart">
            <div class="btn-group">
                <button id="fmt_old" name="z-lyrics-old" class="btn btn-outline-secondary"
                        onclick="SwitchVisibility(this)"
                >{{ __('labels.btn_io_lyrics_old') }}</button>
                <button id="fmt_both" name="z-lyrics-both" class="btn btn-outline-secondary"
                        onclick="SwitchVisibility(this)"
                >{{ __('labels.btn_io_lyrics_both') }}</button>
                <button id="fmt_new" name="z-lyrics-new" class="btn btn-outline-secondary"
                        onclick="SwitchVisibility(this)"
                >{{ __('labels.btn_io_lyrics_new') }}</button>
            </div>
        </div>
    </div>

    <!-- Options -->
    <div class="x-part">
        <div class="z-import"></div>
        <div class="z-export btn-group">
            <button id="option_strict" name="z-option-strict" class="btn btn-outline-secondary x-btn-small-padding"
                    onclick="SwitchVisibility(this)"
            >{{ __('labels.btn_export_op_strict') }}</button>
            <button id="option_loose" name="z-option-loose" class="btn btn-outline-secondary x-btn-small-padding"
                    onclick="SwitchVisibility(this)"
            >{{ __('labels.btn_export_op_loose') }}</button>
        </div>
    </div>

    <!-- Text area -->
    <div class="x-part x-part-small-margin-bottom">
        <textarea id="textarea_import" class="z-import"></textarea>
        <div class="z-export">
            <textarea id="textarea_export_old" class="z-lyrics-old" readonly></textarea>
            <div class="z-lyrics-both">
                <textarea id="textarea_export_both_strict" class="z-option-strict" readonly></textarea>
                <textarea id="textarea_export_both_loose" class="z-option-loose" readonly></textarea>
            </div>
            <div class="z-lyrics-new">
                <textarea id="textarea_export_new_strict" class="z-option-strict" readonly></textarea>
                <textarea id="textarea_export_new_loose" class="z-option-loose" readonly></textarea>
            </div>
        </div>
	</div>
    
    <!-- Example -->
    <div class="x-part">
        Example
        <div class="z-import">
            <div class="z-lyrics-old alert alert-secondary">{!! __('texts.example_import_old') !!}</div>
            <div class="z-lyrics-both alert alert-secondary">{!! __('texts.example_import_both') !!}</div>
            <div class="z-lyrics-new alert alert-secondary">{!! __('texts.example_import_new') !!}</div>
        </div>
        <div class="z-export">
            <div class="z-lyrics-old alert alert-secondary">{!! __('texts.example_export_old') !!}</div>
            <div class="z-lyrics-both alert alert-secondary">{!! __('texts.example_export_both') !!}</div>
            <div class="z-lyrics-new alert alert-secondary">{!! __('texts.example_export_new') !!}</div>
        </div>
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
                    onclick="SaveImportLyrics('textarea_import', '{{ route('songio_import_new', ['id' => $song]) }}')"
            >{{ __('labels.btn_import_submit') }}</button>
        </div>
        <div class="z-export">
            <div class="z-lyrics-old">
                <button class="z-option-strict z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_old_strict"
                >{{ __('labels.btn_export_copy') }}</button>
                <button class="z-option-loose z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_old_loose"
                >{{ __('labels.btn_export_copy') }}</button>
            </div>
            <div class="z-lyrics-both">
                <button class="z-option-strict z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_both_strict"
                >{{ __('labels.btn_export_copy') }}</button>
                <button class="z-option-loose z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_both_loose"
                >{{ __('labels.btn_export_copy') }}</button>
            </div>
            <div class="z-lyrics-new">
                <button class="z-option-strict z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_new_strict"
                >{{ __('labels.btn_export_copy') }}</button>
                <button class="z-option-loose z-btn-clipboard btn btn-outline-primary"
                        data-clipboard-target="#textarea_export_new_loose"
                >{{ __('labels.btn_export_copy') }}</button>
            </div>
        </div>        
    </div>
</div>

<script>
$(document).ready(function(){
    // activate autosize
    autosize($('textarea'));
    // activate clipboard
    new ClipboardJS('.z-btn-clipboard');
    // initialize selection (select from io_import/_export & fmt_old/_new & option_strict/_loose)
    SwitchVisibility($('#io_export').get());
    SwitchVisibility($('#fmt_new').get());
    SwitchVisibility($('#option_strict').get());
    // load export text in textarea (load all now...)
    LoadExportLyrics('textarea_export_new_strict', '{{ route('songio_export_new', ['id' => $song]) }}');
    LoadExportLyrics('textarea_export_new_loose', '{{ route('songio_export_new', ['id' => $song]) }}', false);
    LoadExportLyrics('textarea_export_both_strict', '{{ route('songio_export_both', ['id' => $song]) }}');
    LoadExportLyrics('textarea_export_both_loose', '{{ route('songio_export_both', ['id' => $song]) }}', false);
    LoadExportLyrics('textarea_export_old', '{{ route('songio_export_old', ['id' => $song]) }}');
});
</script>
@endsection
