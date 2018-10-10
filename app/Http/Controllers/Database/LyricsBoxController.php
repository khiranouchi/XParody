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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LyricsBox  $lyricsBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(LyricsBox $lyricsBox)
    {
        //
    }
}
