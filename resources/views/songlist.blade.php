@extends('layouts.app')

@section('flgnavbar')
@endsection

@section('subtitle')
{{ __('labels.subtitle_song_list') }}
@endsection

@section('head')
<script src="{{ asset('js/jquery.tablesorter.js') }}"></script>
<script src="{{ asset('js/jquery.metadata.js') }}"></script>
<script src="{{ asset('js/jquery.metatext.js') }}"></script>
<script src="{{ asset('js/songlist.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <!-- Filter -->
    <div class="row">
        <div class="pl-1 pb-sm-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="checkbox_incomplete"
                       onchange="FilterVisibleRow(this.checked, 'z-song-row-0', '{{ route('cookie_save') }}', '{{ config('const.COOKIE_SONGLIST_INCOMPLETE_KEY') }}')"
                       @if ($dict_row_visibility['incomplete'] != '0')
                       checked
                       @endif
                >
                <label class="form-check-label" for="checkbox_incomplete">{{ __('labels.checkbox_incomplete') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="checkbox_complete"
                       onchange="FilterVisibleRow(this.checked, 'z-song-row-1', '{{ route('cookie_save') }}', '{{ config('const.COOKIE_SONGLIST_COMPLETE_KEY') }}')"
                       @if ($dict_row_visibility['complete'] != '0')
                       checked
                       @endif
                >
                <label class="form-check-label" for="checkbox_complete">{{ __('labels.checkbox_complete') }}</label>
            </div>
        </div>
    </div>

    <!-- Song list -->
    <div class="row">
        <div class="table-responsive">
            <table id="table_song_list" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="{sorter:'metatext'}">{{ __('labels.song_name_old') }}</th>
                        <th class="{sorter:'metatext'}">{{ __('labels.song_name_new') }}</th>
                        <th class="{sorter:'metatext'}">{{ __('labels.song_updated_time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($songs as $song)
                    <tr class="z-song-row-{{ $song->is_complete }}"
                        onclick="window.location.href='{{ route('songs.show', ['id' => $song]) }}'"
                        @if (($song->is_complete == '0' and $dict_row_visibility['incomplete'] == '0') or ($song->is_complete == '1' and $dict_row_visibility['complete'] == '0'))
                        style="display: none"
                        @endif
                    >
                        <td class="{sortValue: '{{ $song->name_old_ruby }}' } x-text-word-break">{{ $song->name_old }}</td>
                        <td class="{sortValue: '{{ $song->name_new_ruby }}' } x-text-word-break">{{ $song->name_new }}</td>
                        <td class="{sortValue: '{{ $song->updated_at }}' }
                                   @if ($song->is_complete)
                                   text-success
                                   @endif
                        ">{{ $song->getUpdatedAtDate() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="button_add">
    <button onclick="window.location.href='{{ route('songs.create') }}'" class="btn btn-circle btn-primary">
        +
    </button>
</div>

<script>
$(document).ready(function(){
    // activate tablesorter
    $("#table_song_list").tablesorter();
});
</script>
@endsection
