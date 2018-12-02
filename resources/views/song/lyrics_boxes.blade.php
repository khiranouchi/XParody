@foreach ($lyrics_boxes as $lyrics_box)
<div id="z_box_{{ $lyrics_box->id }}" class="x-lyrics-box">
    <!-- lyrics-old -->
    <div id="z_box_line_old_{{ $lyrics_box->id }}" class="x-lyrics-old x-row-margin-reset row">
        <div class="x-lyrics-text"
             @if (!$song->is_complete)
             onclick="SwitchInputMode(this, '{{ route('lyrics_boxs.update', ['song' => $song, 'lyrics_box' => $lyrics_box]) }}', 'lyrics_old', false)"
             @endif
        @if ($lyrics_box->lyrics_old === "")
        >(empty)</div>
        @else
        >{{ $lyrics_box->lyrics_old }}</div>
        @endif

        <!-- Delete button -->
        @if (!$song->is_complete)
        <div class="x-lyrics-box-delete"
             onclick="DeleteBox(this, '{{ route('lyrics_boxs.destroy', ['song' => $song, 'lyrics_box' => $lyrics_box]) }}')"
        >[[-]]</div>
        @endif

        <!-- Insert before button -->
        @if (!$song->is_complete)
        <div class="x-lyrics-box-insert-before"
             onclick="InsertBox('z_box_{{ $lyrics_box->id }}', '{{ route('lyrics_boxs.store', ['song' => $song]) }}', '{{ $lyrics_box->box_idx }}', true)"
        >[[^]]</div>
        @endif

        <!-- Insert button -->
        @if (!$song->is_complete)
        <div class="x-lyrics-box-insert"
             onclick="InsertBox('z_box_{{ $lyrics_box->id }}', '{{ route('lyrics_boxs.store', ['song' => $song]) }}', '{{ $lyrics_box->box_idx }}')"
        >[[v]]</div>
        @endif

        <!-- Insert button of box-line -->
        @if (!$song->is_complete)
        <div class="x-lyrics-line-insert"
             onclick="InsertBoxLine('z_box_line_old_{{ $lyrics_box->id }}', '{{ route('lyrics_box_lines.store', ['song' => $song, 'lyrics_box' => $lyrics_box]) }}', '-1')"
        >[+]</div>
        @endif
    </div>

    <!-- lyrics-new -->
    @include('song.lyrics_box_lines', ['lyrics_box_lines' => $dict_lyrics_box_lines[$lyrics_box->id]])
</div>
@endforeach
