@foreach ($lyrics_box_lines as $lyrics_box_line)
<div id="z_box_line_{{ $lyrics_box_line->id }}" class="x-lyrics-new x-row-margin-reset row">
    <div class="x-lyrics-text"
         onclick="SwitchInputMode(this, '{{ route('lyrics_box_lines.update', ['id' => $lyrics_box_line]) }}', 'lyrics_new', false)"
    @if ($lyrics_box_line->lyrics_new === "")
    >(new_line)</div> <!-- TODO -->
    @else
    >{{ $lyrics_box_line->lyrics_new }}</div>
    @endif

    <div class="x-lyrics-level">{{ $lyrics_box_line->level }}</div>

    @if (isset($lyrics_box_line->user))
    <div class="x-lyrics-user d-flex align-items-center"
         style="background-color:{{ $lyrics_box_line->user->getIconColorRgbString() }}">
         <span>{{ $lyrics_box_line->user->icon_char }}</span>
    </div>
    @endif

    <!-- Delete button -->
    <div class="x-lyrics-delete"
         onclick="DeleteBoxLine(this, '{{ route('lyrics_box_lines.destroy', ['id' => $lyrics_box_line]) }}')"
    >[-]</div>

    <!-- Insert button -->
    <div class="x-lyrics-insert"
         onclick="InsertBoxLine('z_box_line_{{ $lyrics_box_line->id }}', '{{ route('lyrics_box_lines.store') }}', '{{ $lyrics_box_line->box_id }}', '{{ $lyrics_box_line->line_idx }}')"
    >[+]</div>
</div>
@endforeach
