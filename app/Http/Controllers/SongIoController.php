<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\LyricsBox;
use App\Models\LyricsBoxLine;

class SongIoController extends Controller
{
    /**
     * Middlewares which executes before each action.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the i/o pages of the specified song.
     * 
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function index(Song $song)
    {
        return view('songio', ['song' => $song]);
    }
    
    /**
     * Store multiple lyrics-old to the table LyricsBox.
     * 
     * @param  \App\Models\Song  $song
     * $return \Illuminate\Http\Response
     */
    public function storeAllLyricsOld(Request $request, Song $song)
    {
        $song_id = $song->id;
        
        // delete all existing lines with specified song_id in LyricsBox (lines in LyricsBoxLine is cascade)
        LyricsBox::where('song_id', $song_id)->delete();

        // store to table LyricsBox and LyricsBoxLine
        $list_lyrics_old = preg_split("/\R/", $request['data']);
        $box_idx = 0;
        foreach ($list_lyrics_old as $lyrics_old) {
            // create new line in LyricsBox
            $lyrics_box = new LyricsBox;
            $lyrics_box->song_id = $song_id;
            $lyrics_box->box_idx = $box_idx;
            $lyrics_box->lyrics_old = $lyrics_old;
            $lyrics_box->save();

            // create one new line with the box_idx in LyricsBoxLine
            $lyrics_box_line = new LyricsBoxLine;
            $lyrics_box_line->box_id = $lyrics_box->id;
            $lyrics_box_line->line_idx = 0;
            $lyrics_box_line->lyrics_new = '';
            $lyrics_box_line->level = LyricsBoxLine::getMaxLevel();
            $lyrics_box_line->save();

            $box_idx++;
        }

        return response()->json(['url' => route('songs.show', ['id' => $song])], 201);
    }
}
