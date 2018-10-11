@foreach ($lyrics_boxes as $lyrics_box)
<div class="x-lyrics-box">
    <!-- lyrics-old -->
    <div id="z_box_line_old_{{ $lyrics_box->id }}" class="x-lyrics-old x-row-margin-reset row">
        <div class="x-lyrics-text"
             onclick="SwitchInputMode(this, '{{ route('lyrics_boxs.update', ['id' => $lyrics_box]) }}', 'lyrics_old')"
        >{{ $lyrics_box->lyrics_old }}</div>
        <div class="x-lyrics-insert"
             onclick="InsertBoxLine('z_box_line_old_{{ $lyrics_box->id }}', '{{ route('lyrics_box_lines.store') }}', '{{ $lyrics_box->id }}', '-1')"
        >[+]</div>
    </div>
    <!-- lyrics-new -->
    @include('song.lyrics_box_lines', ['lyrics_box_lines' => $dict_lyrics_box_lines[$lyrics_box->id]])
</div>
@endforeach
