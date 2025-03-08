<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\RedirectLog;

class AnalyticsController extends Controller
{
    public function show($shortCode)
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        $redirects = RedirectLog::where('url_id', $url->id)->get();

        return response()->json([
            'original_url' => $url->original_url,
            'short_url' => url('/') . '/' . $url->short_code,
            'redirect_count' => $redirects->count(),
            'redirects' => $redirects,
        ]);
    }
}