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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * $return \Illuminate\Http\Response
     */
    public function storeAllLyricsOld(Request $request, Song $song)
    {
        // unable to import lyrics when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        $song_id = $song->id;

        // delete all existing lines with specified song_id in LyricsBox (lines in LyricsBoxLine is cascade)
        LyricsBox::where('song_id', $song_id)->delete();

        // store to table LyricsBox
        $list_lyrics_old = preg_split('/\r\n|\n|\r/', $request['data']);
        $box_idx = 0;
        foreach ($list_lyrics_old as $lyrics_old) {
            // create new line in LyricsBox
            $lyrics_box = new LyricsBox;
            $lyrics_box->song_id = $song_id;
            $lyrics_box->box_idx = $box_idx;
            $lyrics_box->lyrics_old = LyricsBox::filterEmptyLyrics(trim(mb_convert_kana($lyrics_old, "s")));
            $lyrics_box->save();

            $box_idx++;
        }

        // update timestamps of the song
        $song->touch();

        return response()->json(['url' => route('songs.show', ['id' => $song])], 201);
    }

    /**
     * Store multiple lyrics-old/new to the table LyricsBox/LyricsBoxLine.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * $return \Illuminate\Http\Response
     */
    public function storeAllLyricsBoth(Request $request, Song $song)
    {
        // unable to import lyrics when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        $song_id = $song->id;

        // delete all existing lines with specified song_id in LyricsBox (lines in LyricsBoxLine is cascade)
        LyricsBox::where('song_id', $song_id)->delete();

        // store to table LyricsBox and LyricsBoxLine
        $list_lyrics = preg_split('/\r\n|\n|\r/', $request['data']);
        $i = -1;
        $box_idx = 0;
        while (true) {
            $i++;

            if (!array_key_exists($i, $list_lyrics)){
                break;
            }

            $lyrics = trim(mb_convert_kana($list_lyrics[$i], "s"));

            // create new line in LyricsBox
            $lyrics_box = new LyricsBox;
            $lyrics_box->song_id = $song_id;
            $lyrics_box->box_idx = $box_idx;
            $lyrics_box->lyrics_old = LyricsBox::filterEmptyLyrics($lyrics);
            $lyrics_box->save();

            if ($lyrics !== "") {
                $line_idx = 0;

                // read line as new-lyrics until empty line appears
                while(true) {
                    $i++;

                    if (!array_key_exists($i, $list_lyrics)) {
                        break;
                    }

                    $lyrics = trim(mb_convert_kana($list_lyrics[$i], "s"));

                    if($lyrics === "") {
                        break;
                    }

                    // create one new line with the box_idx in LyricsBoxLine
                    $lyrics_box_line = new LyricsBoxLine;
                    $lyrics_box_line->box_id = $lyrics_box->id;
                    $lyrics_box_line->line_idx = $line_idx;
                    $lyrics_box_line->lyrics_new = $lyrics;
                    $lyrics_box_line->level = LyricsBoxLine::getAvailableMaxLevel($lyrics_box->id);
                    $lyrics_box_line->user_id = $request->user()->id;
                    $lyrics_box_line->save();

                    $line_idx++;
                }
            }

            $box_idx++;
        }

        // update timestamps of the song
        $song->touch();

        return response()->json(['url' => route('songs.show', ['id' => $song])], 201);
    }

    /**
     * Store multiple lyrics-new to the table LyricsBox/LyricsBoxLine.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * $return \Illuminate\Http\Response
     */
    public function storeAllLyricsNew(Request $request, Song $song)
    {
        // unable to import lyrics when song's complete flag is on
        if($song->is_complete) {
            abort(404);
        }

        $song_id = $song->id;

        // delete all existing lines with specified song_id in LyricsBox (lines in LyricsBoxLine is cascade)
        LyricsBox::where('song_id', $song_id)->delete();

        // store to table LyricsBox and LyricsBoxLine
        $list_lyrics_new = preg_split('/\r\n|\n|\r/', $request['data']);
        $box_idx = 0;
        foreach ($list_lyrics_new as $lyrics_new) {
            // create new line in LyricsBox
            $lyrics_box = new LyricsBox;
            $lyrics_box->song_id = $song_id;
            $lyrics_box->box_idx = $box_idx;
            $lyrics_box->lyrics_old = LyricsBox::filterEmptyLyrics(''); //set empty string
            $lyrics_box->save();

            $lyrics_new = trim(mb_convert_kana($lyrics_new, "s"));
            if ($lyrics_new !== "") {
                // create new line in LyricsBoxLine
                $lyrics_box_line = new LyricsBoxLine;
                $lyrics_box_line->box_id = $lyrics_box->id;
                $lyrics_box_line->line_idx = 1;
                $lyrics_box_line->lyrics_new = $lyrics_new;
                $lyrics_box_line->level = LyricsBoxLine::getMaxLevel();
                $lyrics_box_line->user_id = $request->user()->id;
                $lyrics_box_line->save();
            }

            $box_idx++;
        }

        // update timestamps of the song
        $song->touch();

        return response()->json(['url' => route('songs.show', ['id' => $song])], 201);
    }

    /**
     * Index multiple lyrics-new from the table LyricsBoxLine.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * $return \Illuminate\Http\Response
     */
    public function indexAllLyricsNew(Request $request, Song $song)
    {
        $content = '';

        $box_ids = LyricsBox::where('song_id', $song->id)->orderBy('box_idx')->pluck('id');

        // add one lyrics-new from each lyrics-box
        foreach ($box_ids as $box_id) {
            $ln_lyrics_box_lines = LyricsBoxLine::where('box_id', $box_id);
            if (!$ln_lyrics_box_lines->get()->isEmpty()) {
                // if strict
                if ($request->strict === "true") {
                    // choose one with max-level (should be only one)
                    $lyrics_box_lines_max = $ln_lyrics_box_lines->where('level', LyricsBoxLine::getMaxLevel())->get();
                    if (count($lyrics_box_lines_max) === 1) {
                        $content .= $lyrics_box_lines_max[0]->lyrics_new; //add
                    } else {
                        return response(__('labels.error_song_export_max_level_duplicate'));
                    }
                // if loose
                } else {
                    // choose the most higher level (select only one which appears first(smaller line-idx))
                    $lyrics_box_line = $ln_lyrics_box_lines->orderBy('level', 'desc')->orderBy('line_idx', 'desc')->take(1)->get()[0];
                    $content .= $lyrics_box_line->lyrics_new; //add
                }
            }
            $content .= "\n";
        }

        return response($content);
    }
}
