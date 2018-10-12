@foreach ($lyrics_boxes as $lyrics_box)
<div class="x-lyrics-box">
    <!-- lyrics-old -->
    <div id="z_box_line_old_{{ $lyrics_box->id }}" class="x-lyrics-old x-row-margin-reset row">
        <div class="x-lyrics-text"
             onclick="SwitchInputMode(this, '{{ route('lyrics_boxs.update', ['id' => $lyrics_box]) }}', 'lyrics_old', false)"
        @if ($lyrics_box->lyrics_old === "")
        >(empty)</div>
        @else
        >{{ $lyrics_box->lyrics_old }}</div>
        @endif

        <!-- Delete button -->
        <div class="x-lyrics-box-delete"
             onclick="DeleteBox(this, '{{ route('lyrics_boxs.destroy', ['id' => $lyrics_box]) }}')"
        >[[-]]</div>

        <!-- Insert before button -->
        <div class="x-lyrics-box-insert-before">[[^]]</div>

        <!-- Insert button -->
        <div class="x-lyrics-box-insert">[[v]]</div>

        <!-- Insert button of box-line -->
        <div class="x-lyrics-line-insert"
             onclick="InsertBoxLine('z_box_line_old_{{ $lyrics_box->id }}', '{{ route('lyrics_box_lines.store') }}', '{{ $lyrics_box->id }}', '-1')"
        >[+]</div>
    </div>
    <!-- lyrics-new -->
    @include('song.lyrics_box_lines', ['lyrics_box_lines' => $dict_lyrics_box_lines[$lyrics_box->id]])
</div>
@endforeach
