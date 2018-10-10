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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
