<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\LyricsBox;
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
        //
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
