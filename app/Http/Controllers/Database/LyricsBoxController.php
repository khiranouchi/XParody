<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\LyricsBox;
use App\Models\LyricsBoxLine;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\EditHistory;

class LyricsBoxController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Song $song)
    {
        // unable to store when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        // set box_idx of new box
        if ($request->insert_before === "true") {
            $box_idx = LyricsBox::find($request->box_id)->box_idx;
        } else {
            $box_idx = LyricsBox::find($request->box_id)->box_idx + 1;
        }

        $lyrics_box = new LyricsBox;

        $lyrics_box->lyrics_old = $request->lyrics_old;

        $song_id = $song->id;
        $lyrics_box->song_id = $song_id;
        $lyrics_box->box_idx = $box_idx;

        // increment box_idx of every existing table line, if its box_idx >= new box_idx.
        // eg. [a(1), b(2), c(3), d(4)] + f(3) --> [a(1), b(2), f(3), c(4), d(5)]
        LyricsBox::where('song_id', $song_id)->where('box_idx', '>=', $box_idx)->increment('box_idx');

        $lyrics_box->save();

        // update timestamps of the song
        $song->touch();

        // create edit history
        EditHistoryController::store($request, $song, EditHistory::EDIT_TYPE_LYRICS_BOX);

        // $dict_lyrics_box_line is list of LyricsBoxLine lines ordered by line_idx of each box,
        // but at this time we only need 'empty list' of 'one created box'.
        $dict_lyrics_box_lines = array();
        $dict_lyrics_box_lines[$lyrics_box->id] = array();

        return view('song.lyrics_boxes', [
            'song' => $song,
            'lyrics_boxes' => [$lyrics_box],
            'dict_lyrics_box_lines' => $dict_lyrics_box_lines,
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song, LyricsBox $lyricsBox)
    {
        // unable to update when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        if ($request->isMethod('PATCH')) {
            foreach ($lyricsBox->getAllColumnNames() as $fields) {
                if ($request->filled($fields)) {
                    $lyricsBox->$fields = $request->$fields;
                }
            }

            // if lyricsBox is actually modified)
            if($lyricsBox->isDirty()) {
                // update timestamps of the song
                $song->touch();
                // create edit history
                EditHistoryController::store($request, $song, EditHistory::EDIT_TYPE_LYRICS_BOX);
            }

            $lyricsBox->save();

            return response(null, 204);
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage (lines in LyricsBoxLine is cascade).
     *
     * @param  \App\Models\Song  $song
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Song $song, LyricsBox $lyricsBox)
    {
        // unable to destroy when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        // decrement box_idx of every existing table line, if its box_idx > deleted box_idx.
        // eg. [a(1), b(2), c(3), d(4), e(5)] - c(3) --> [a(1), b(2), d(3), e(4)]
        $song_id = $song->id;
        $box_idx = $lyricsBox->box_idx;
        LyricsBox::where('song_id', $song_id)->where('box_idx', '>', $box_idx)->decrement('box_idx');

        $lyricsBox->delete();

        // update timestamps of the song
        $song->touch();

        // create edit history
        EditHistoryController::store($request, $song, EditHistory::EDIT_TYPE_LYRICS_BOX);

        return response(null, 204);
    }
}
