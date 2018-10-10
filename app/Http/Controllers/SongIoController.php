<?php

namespace App\Http\Controllers;

use App\Models\Song;

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
        return view('songio');
    }
    
}
