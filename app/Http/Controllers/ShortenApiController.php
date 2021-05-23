<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortenedUrls;
use App\Http\Controllers\ShortenerHelperController;

class ShortenApiController extends Controller
{
    private $shortenedBaseurl;

    public function __construct()
    {
        $this->shortenedBaseurl = env('APP_URL') . DIRECTORY_SEPARATOR;
    }

    public function top()
    {
        $topUrls = ShortenedUrls::select('source_url', 'shortened_url', 'visited', 'created_at')
                                ->orderByDesc('visited')
                                ->limit(100)
                                ->get();

        if ($topUrls->isEmpty()) return response()->json(['error' => 'No shortened urls available!']);

        return response()->json($topUrls);
    }

    public function shortenUrl(Request $request)
    {
        if (empty($request->url)) return response()->json(['error' => 'Missing url in the request!']);

        if (!filter_var($request->url, FILTER_VALIDATE_URL)) return response()->json(['error' => 'Invalid url in the request!']);

        $shortenedUrl = new ShortenedUrls;

        $shortenedUrl->source_url = $request->url;
        $shortenedUrl->shortened_url = ShortenerHelperController::genShortenedUrl();

        if (!empty($request->nsfw) && $request->nsfw == 1) $shortenedUrl->nsfw = 1;

        $shortenedUrl->save();

        return response()->json(["url" => $this->shortenedBaseurl . $shortenedUrl->shortened_url]);
    }

    public function redirect($url)
    {
        if (empty($url)) return response()->json(['error' => 'Missing url in the request!']);

        $sourceUrl = ShortenedUrls::select('source_url')
                                ->where('shortened_url', $url)
                                ->get();

        if ($sourceUrl->isEmpty()) return response()->json(['error' => 'The shortened url could not be found!']);

        ShortenerHelperController::incrementVisit($url);

        return response()->json(['redirect_url' => $sourceUrl[0]->source_url]);
    }
}
