@foreach ($lyrics_box_lines as $lyrics_box_line)
<div id="z_box_line_{{ $lyrics_box_line->id }}" class="x-lyrics-new x-row-margin-reset row">
    <!-- new-lyrics -->
    <div class="x-lyrics-text"
         @if (!isset($lyrics_box_line->user) or $request_user_id === $lyrics_box_line->user->id)
         onclick="SwitchInputMode(this, '{{ route('lyrics_box_lines.update', ['song' => $song, 'lyrics_box' => $lyrics_box, 'lyrics_box_line' => $lyrics_box_line]) }}', 'lyrics_new', false)"
         @endif
    @if ($lyrics_box_line->lyrics_new === "")
    >(new_line)</div> <!-- TODO -->
    @else
    >{{ $lyrics_box_line->lyrics_new }}</div>
    @endif

    <!-- level -->
    <div class="x-lyrics-level"
         onclick="SwitchSelectMode(this, '{{ route('lyrics_box_lines.update', ['song' => $song, 'lyrics_box' => $lyrics_box, 'lyrics_box_line' => $lyrics_box_line]) }}', 'level', '{{ $list_box_lines_levels }}')"
    >{{ $lyrics_box_line->level }}</div>

    <!-- user -->
    @if (isset($lyrics_box_line->user))
    <div class="x-lyrics-user d-flex align-items-center"
         style="background-color:{{ $lyrics_box_line->user->getIconColorRgbString() }}">
         <span>{{ $lyrics_box_line->user->icon_char }}</span>
    </div>
    @endif

    <!-- Delete button -->
    @if (!isset($lyrics_box_line->user) or $request_user_id === $lyrics_box_line->user->id)
    <div class="x-lyrics-line-delete"
         onclick="DeleteBoxLine(this, '{{ route('lyrics_box_lines.destroy', ['song' => $song, 'lyrics_box' => $lyrics_box, 'lyrics_box_line' => $lyrics_box_line]) }}')"
    >[-]</div>
    @endif

    <!-- Insert button -->
    <div class="x-lyrics-line-insert"
         onclick="InsertBoxLine('z_box_line_{{ $lyrics_box_line->id }}', '{{ route('lyrics_box_lines.store', ['song' => $song, 'lyrics_box' => $lyrics_box]) }}', '{{ $lyrics_box_line->box_id }}', '{{ $lyrics_box_line->line_idx }}')"
    >[+]</div>
</div>
@endforeach
