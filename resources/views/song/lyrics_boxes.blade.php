@foreach ($lyrics_boxes as $lyrics_box)
<div class="x-lyrics-box">
    <!-- lyrics-old -->
    <div class="x-lyrics-old">
        <div class="x-lyrics-text"
             onclick="SwitchInputMode(this, '{{ route('lyrics_boxs.update', ['id' => $lyrics_box]) }}', 'lyrics_old')"
        >{{ $lyrics_box->lyrics_old }}</div>
    </div>
    <!-- lyrics-new -->
    @include('song.lyrics_box_lines', ['lyrics_box_lines' => $dict_lyrics_box_lines[$lyrics_box->id]])
    <div class="x-lyrics-new">(+new)</div>
</div>
@endforeach
