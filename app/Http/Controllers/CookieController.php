<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    private static function getKeys()
    {
        return [
            config('const.COOKIE_SONGLIST_INCOMPLETE_KEY'),
            config('const.COOKIE_SONGLIST_COMPLETE_KEY')
        ];
    }

    /**
     * Save cookies.
     * @param Request $request
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $response = response(null, 204);
            $minutes = 60 * 24 * 365 * 10; // 10 years
            foreach ($this->getKeys() as $key) {
                if ($request->filled($key)) {
                    $response->cookie($key, $request->$key, $minutes);
                }
            }
            return $response;
        } else {
            return abort(501);
        }
    }
}
