<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\ShortenedUrls;
use Hashids\Hashids;

class ShortenController extends Controller
{
    private $shortenedBaseurl;

    private static $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct()
    {
        $this->shortenedBaseurl = env('APP_URL') . DIRECTORY_SEPARATOR;
    }

    public function genShortenedUrl()
    {
        $hashids = new Hashids();

        do {
            $shortenedUrl = $hashids->encode(random_int(0, 9), random_int(0, 9), random_int(0, 9));

            $checkUrl = ShortenedUrls::where('shortened_url', $shortenedUrl)->get();
        } while (!$checkUrl->isEmpty());

        return $shortenedUrl;
    }

    public function incrementVisit($url)
    {
        $increment = ShortenedUrls::where('shortened_url', $url)->get()[0];

        $increment->visited = $increment->visited + 1;

        $increment->save();
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

        $shortenedUrl = new ShortenedUrls;

        $shortenedUrl->source_url = $request->url;
        $shortenedUrl->shortened_url = $this->genShortenedUrl();

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

        $this->incrementVisit($url);

        return response()->json(['redirect_url' => $sourceUrl[0]->source_url]);
    }
}
