<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\LyricsBox;

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
        // delete all old/new lyrics
        // TODO

        // store to table LyricsBox
        $list_lyrics_old = preg_split("/\R/", $request['data']);
        $song_id = $song->id;
        $box_idx = 0;
        foreach ($list_lyrics_old as $lyrics_old) {
            $lyrics_box = new LyricsBox;
            $lyrics_box->song_id = $song_id;
            $lyrics_box->box_idx = $box_idx;
            $lyrics_box->lyrics_old = $lyrics_old;
            $lyrics_box->save();
            $box_idx++;
        }

        return response()->json(['url' => route('songs.show', ['id' => $song])], 201);
    }
}
