@foreach ($lyrics_box_lines as $lyrics_box_line)
<div class="x-lyrics-new x-row-margin-reset row">
    <div class="x-lyrics-text">{{ $lyrics_box_line->lyrics_new }}</div>
    <div class="x-lyrics-level">{{ $lyrics_box_line->level }}</div>
    @if (isset($lyrics_box_line->user))
    <div class="x-lyrics-user d-flex align-items-center"
         style="background-color:{{ $lyrics_box_line->user->getIconColorRgbString() }}">
         <span>{{ $lyrics_box_line->user->icon_char }}</span>
    </div>
    @endif
</div>
@endforeach
