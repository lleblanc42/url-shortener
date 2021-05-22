<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\ShortenedUrls;
use Hashids\Hashids;

class ShortenController extends Controller
{
    private const SHORTENED_BASEURL = env('APP_URL') . DIRECTORY_SEPARATOR;

    private static $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function genShortenedUrl()
    {
        $hashids = new Hashids();

        do {
            $shortenedUrl = $hashids->encode(1, 2, 3);

            $checkUrl = ShortenedUrls::where('shortened_url', $shortenedUrl)->get();
        } while (!empty($checkUrl));

        return $shortenedUrl;
    }

    public function top()
    {
        $topUrls = ShortenedUrls::select('source_url', 'shortened_url', 'visited', 'created_at')
                                ->orderBy('visited')
                                ->limit(100)
                                ->get();

        if (empty($topUrls)) return response()->json(['error' => 'No shortened urls available!']);

        return response()->json($topUrls);
    }

    public function shortenUrl(Request $request)
    {
        if (empty($request->url)) return response()->json(['error' => 'Missing url in the request!']);

        $shortenedUrl = new ShortenedUrls;

        $shortenedUrl->source_url = $request->url;
        $shortenedUrl->shortened_url = $this->genShortenedUrl();

        $shortenedUrl->save();

        return response()->json(["url" => self::SHORTENED_BASEURL . $shortenedUrl->shortened_url]);
    }

    public function redirect($url)
    {
        if (empty($url)) return response()->json(['error' => 'Missing url in the request!']);

        $sourceUrl = ShortenedUrls::select('source_url')
                                ->where('shortened_url', $url)
                                ->get();

        if (empty($sourceUrl)) return response()->json(['error' => 'The shortened url could not be found!']);

        return response()->json(['redirect_url' => $sourceUrl]);
    }
}
