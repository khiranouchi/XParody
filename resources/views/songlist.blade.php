@extends('layouts.app')

@section('subtitle')
{{ __('labels.subtitle_song_list') }}
@endsection

@section('head')
<script src="{{ url('../resources/js/jquery/jquery.tablesorter.js') }}"></script>
<script src="{{ url('../resources/js/jquery/jquery.metatext.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">
	        <table id="table_song_list" class="table table-bordered table-hover">
                <thead>
                    <tr>
                    	<th class="{sorter:'metatext'}">{{ __('labels.song_name_old') }}</th>
                    	<th class="{sorter:'metatext'}">{{ __('labels.song_name_new') }}</th>
                    	<th class="{sorter:'metadata'}">{{ __('labels.song_updated_time') }}</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach ($songs as $song)
                	<tr>
                		<td class="{sortValue: '{{ $song->name_old_ruby }}' }">{{ $song->name_old }}</td>
                		<td class="{sortValue: '{{ $song->name_new_ruby }}' }">{{ $song->name_new }}</td>
                		<td class="{sortValue:{{ $song->updated_at }}}">{{ $song->getUpdatedAtDate() }}</td>
                	</tr>
                	@endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// activate tablesorter
$(document).ready(function(){
    $("#table_song_list").tablesorter();
});
</script>
@endsection
