<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\LyricsBoxLine;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\LyricsBox;

class LyricsBoxLineController extends Controller
{
    /**
     * Middlewares which executes before each action.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Song $song, LyricsBox $lyricsBox)
    {
        $lyrics_box_line = new LyricsBoxLine;

        $lyrics_box_line->user_id = $request->user()->id;

        $box_id = $lyricsBox->id;
        $line_idx = $request->line_idx;
        $lyrics_box_line->box_id = $box_id;
        $lyrics_box_line->line_idx = $line_idx;

        // increment line_idx of every existing table line, if its line_idx >= new line_idx.
        // eg. [a(1), b(2), c(3), d(4)] + f(3) --> [a(1), b(2), f(3), c(4), d(5)]
        LyricsBoxLine::where('box_id', $box_id)->where('line_idx', '>=', $line_idx)->increment('line_idx');

        // set old-lyrics as default new-lyrics
        $lyrics_box_line->lyrics_new = LyricsBox::find($box_id)->lyrics_old;

        $lyrics_box_line->level = LyricsBoxLine::getAvailableMaxLevel($box_id);

        $lyrics_box_line->save();

        // update timestamps of the song
        if(!$song->is_complete) {
            $song->touch();
        }

        return view('song.lyrics_box_lines', [
            'song' => $song,
            'lyrics_box' => $lyricsBox,
            'lyrics_box_lines' => [$lyrics_box_line],
            'list_box_lines_levels' => implode(',', LyricsBoxLine::getLevels()),
            'request_user_id' => $request->user()->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song, LyricsBox $lyricsBox, LyricsBoxLine $lyricsBoxLine)
    {
        // only creator can update
        if ($request->filled('lyrics_new')) {
            if ($lyricsBoxLine->user_id === null) {
                $lyricsBoxLine->user_id = $request->user()->id;
            } elseif ($request->user()->id != $lyricsBoxLine->user_id) {
                return response(null, 400);
            }
        }
        
        if ($request->isMethod('PATCH')) {
            foreach ($lyricsBoxLine->getAllColumnNames() as $fields) {
                if ($request->filled($fields)) {
                    $lyricsBoxLine->$fields = $request->$fields;
                }
            }

            // update timestamps of the song (if lyricsBoxLine is actually modified)
            if($lyricsBoxLine->isDirty() and !$song->is_complete) {
                $song->touch();
            }

            $lyricsBoxLine->save();

            return response(null, 204);
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Song $song, LyricsBox $lyricsBox, LyricsBoxLine $lyricsBoxLine)
    {
        // only creator can destroy
        if ($lyricsBoxLine->user_id !== null and $request->user()->id != $lyricsBoxLine->user_id) {
            return response(null, 400);
        }
        
        // decrement line_idx of every existing table line, if its line_idx > deleted line_idx.
        // eg. [a(1), b(2), c(3), d(4), e(5)] - c(3) --> [a(1), b(2), d(3), e(4)]
        $box_id = $lyricsBox->id;
        $line_idx = $lyricsBoxLine->line_idx;
        LyricsBoxLine::where('box_id', $box_id)->where('line_idx', '>', $line_idx)->decrement('line_idx');

        $lyricsBoxLine->delete();

        // update timestamps of the song
        if(!$song->is_complete) {
            $song->touch();
        }

        return response(null, 204);
    }
}
