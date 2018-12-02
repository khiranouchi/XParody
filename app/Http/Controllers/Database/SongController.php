<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\LyricsBox;
use App\Models\LyricsBoxLine;

class SongController extends Controller
{
    /**
     * Middlewares which executes before each action.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::orderBy('updated_at', 'desc')->get();
        return view('songlist', ['songs' => $songs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('song_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $song = new Song;
        $song->name_old = $request->name_old;
        $song->name_old_ruby = $request->name_old_ruby;
        $song->name_new = $request->name_new;
        $song->name_new_ruby = $request->name_new_ruby;
        $song->is_complete = false;
        $song->save();
        return redirect()->route('songs.show', ['id' => $song]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Song $song)
    {
        // get lines of LyricsBox ordered by box_idx
        $song_id = $song->id;
        $ln_lyrics_boxes = LyricsBox::where('song_id', $song_id)->orderBy('box_idx');
        $lyrics_boxes = $ln_lyrics_boxes->get();

        // get lines of LyricsBoxLine ordered by line_idx of each box
        $dict_lyrics_box_lines = array(); //associative array of array
        $box_ids = $ln_lyrics_boxes->pluck('id');
        foreach ($box_ids as $box_id) {
            $dict_lyrics_box_lines[$box_id] = LyricsBoxLine::where('box_id', $box_id)->orderBy('line_idx')->get();
        }

        return view('song', [
            'song' => $song,
            'lyrics_boxes' => $lyrics_boxes,
            'dict_lyrics_box_lines' => $dict_lyrics_box_lines,
            'list_box_lines_levels' => implode(',', LyricsBoxLine::getLevels()),
            'request_user_id' => $request->user()->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        if ($request->isMethod('PATCH')) {
            // Do not update timestamps if is_complete flag is true (see this before the flag itself changed)
            if ($song->is_complete) {
                $song->timestamps = false;
            }

            foreach ($song->getAllColumnNames() as $fields) {
                if ($request->filled($fields)) {
                    $song->$fields = $request->$fields;
                }
            }
            $song->save();

            if ($request->header('accept') == 'application/json') {
                return response(null, 204);
            } else {
                return redirect()->route('songs.show', ['id' => $song]);
            }
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('songs.index');
    }
}
