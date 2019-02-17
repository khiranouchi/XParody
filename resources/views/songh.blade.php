@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('content')
<div class="container">



@foreach ($edit_histories as $edit_history)
<div>[[[[[</div>
<div>{{ $edit_history->id }}</div>
<div>{{ $edit_history->song_id }}</div>
<div class="x-lyrics-user d-flex align-items-center"
     style="background-color:{{ $edit_history->user->getIconColorRgbString() }}">
    <span>{{ $edit_history->user->icon_char }}</span>
</div>
<div>{{ $edit_history->getCreatedAtDateTime() }}</div>
<div>{{ __('labels.'.$edit_history->getEditTypeLabel()) }}</div>
<div>]]]]]</div>
@endforeach



</div>
@endsection
