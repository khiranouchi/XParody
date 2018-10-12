<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\LyricsBox;
use App\Models\LyricsBoxLine;
use Illuminate\Http\Request;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lyrics_box = new LyricsBox;

        $lyrics_box->lyrics_old = $request->lyrics_old;

        $song_id = $request->song_id;
        $box_idx = $request->box_idx;
        $lyrics_box->song_id = $song_id;
        $lyrics_box->box_idx = $box_idx;

        // increment line_idx of every existing table line, if its line_idx >= new line_idx.
        // eg. [a(1), b(2), c(3), d(4)] + f(3) --> [a(1), b(2), f(3), c(4), d(5)]
        LyricsBox::where('song_id', $song_id)->where('box_idx', '>=', $box_idx)->increment('box_idx');

        $lyrics_box->save();

        // $dict_lyrics_box_line is list of LyricsBoxLine lines ordered by line_idx of each box,
        // but at this time we only need 'empty list' of 'one created box'.
        $dict_lyrics_box_lines = array();
        $dict_lyrics_box_lines[$lyrics_box->id] = array();

        return view('song.lyrics_boxes', [
            'lyrics_boxes' => [$lyrics_box],
            'dict_lyrics_box_lines' => $dict_lyrics_box_lines,
            'list_box_lines_levels' => implode(',', LyricsBoxLine::getLevels()),
            'request_user_id' => $request->user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function show(LyricsBox $lyricsBox)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function edit(LyricsBox $lyricsBox)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LyricsBox $lyricsBox)
    {
        if ($request->isMethod('PATCH')) {
            foreach ($lyricsBox->getAllColumnNames() as $fields) {
                if ($request->filled($fields)) {
                    $lyricsBox->$fields = $request->$fields;
                }
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
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(LyricsBox $lyricsBox)
    {
        // decrement box_idx of every existing table line, if its box_idx > deleted box_idx.
        // eg. [a(1), b(2), c(3), d(4), e(5)] - c(3) --> [a(1), b(2), d(3), e(4)]
        $song_id = $lyricsBox->song_id;
        $box_idx = $lyricsBox->box_idx;
        LyricsBox::where('song_id', $song_id)->where('box_idx', '>', $box_idx)->decrement('box_idx');

        $lyricsBox->delete();

        return response(null, 204);
    }
}
