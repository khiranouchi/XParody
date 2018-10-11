<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\LyricsBoxLine;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lyrics_box_line = new LyricsBoxLine;

        $lyrics_box_line->user_id = $request->user()->id;
        $lyrics_box_line->lyrics_new = $request->lyrics_new;

        $box_id = $request->box_id;
        $line_idx = $request->line_idx;
        $lyrics_box_line->box_id = $box_id;
        $lyrics_box_line->line_idx = $line_idx;
        LyricsBoxLine::where('box_id', $box_id)->where('line_idx', '>=', $line_idx)->increment('line_idx');

        if (LyricsBoxLine::where('box_id', $box_id)->where('level', 5)->exists()) {
            $lyrics_box_line->level = LyricsBoxLine::getMaxLevel() - 1;
        } else {
            $lyrics_box_line->level = LyricsBoxLine::getMaxLevel();
        }

        $lyrics_box_line->save();
        
        return view('song.lyrics_box_lines', ['lyrics_box_lines' => [$lyrics_box_line]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function show(LyricsBoxLine $lyricsBoxLine)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function edit(LyricsBoxLine $lyricsBoxLine)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LyricsBoxLine $lyricsBoxLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LyricsBoxLine  $lyricsBoxLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(LyricsBoxLine $lyricsBoxLine)
    {
        //
    }
}
