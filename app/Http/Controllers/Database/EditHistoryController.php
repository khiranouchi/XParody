<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\EditHistory;
use App\Models\Song;
use Illuminate\Http\Request;

class EditHistoryController extends Controller
{
    /**
     * Middlewares which executes before each action.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function store(Request $request, Song $song, $edit_type)
    {
        $edit_history = new EditHistory;
        $edit_history->song_id = $song->id;
        $edit_history->user_id = $request->user()->id;
        $edit_history->edit_type = $edit_type;
        $edit_history->save();

        // delete the oldest row
        $edit_histories = EditHistory::where('song_id', $song->id);
        $latest_edit_histories = $edit_histories->orderBy('created_at', 'desc')->take(10)->select('created_at')->get();
        $edit_histories->whereNotIn('created_at', $latest_edit_histories)->delete();
    }

    public static function getLatest(Song $song)
    {
        return EditHistory::where('song_id', $song->id)->orderBy('created_at', 'desc')->take(1)->get()[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Song $song)
    {
        $edit_histories = EditHistory::where('song_id', $song->id)->orderBy('created_at')->get();
        return view('songh', [
            'song' => $song,
            'edit_histories' => $edit_histories
        ]);
    }
}
