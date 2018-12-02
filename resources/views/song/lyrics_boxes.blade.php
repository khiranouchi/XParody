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

        @if (!$song->is_complete)
        <div class="dropdown x-lyrics-box-dropdown">
            <div class="dropdown-toggle" id="z_box_dropdown_{{ $lyrics_box->id }}"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >[=]</div>

            <div class="dropdown-menu" aria-labelledby="z_box_dropdown_{{ $lyrics_box->id }}">
                <!-- Delete button -->
                <div class="dropdown-item"
                     onclick="DeleteBox(this, '{{ route('lyrics_boxs.destroy', ['song' => $song, 'lyrics_box' => $lyrics_box]) }}')"
                >{{ __('labels.dropdown_delete_box') }}</div>

                <!-- Insert before button -->
                <div class="dropdown-item"
                     onclick="InsertBox('z_box_{{ $lyrics_box->id }}', '{{ route('lyrics_boxs.store', ['song' => $song]) }}', '{{ $lyrics_box->box_idx }}', true)"
                >{{ __('labels.dropdown_insert_before_box') }}</div>

                <!-- Insert button -->
                <div class="dropdown-item"
                     onclick="InsertBox('z_box_{{ $lyrics_box->id }}', '{{ route('lyrics_boxs.store', ['song' => $song]) }}', '{{ $lyrics_box->box_idx }}')"
                >{{ __('labels.dropdown_insert_after_box') }}</div>
            </div>
        </div>
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
