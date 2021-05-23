<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShortenedUrls;
use App\Http\Controllers\ShortenerHelperController;

class ShortenController extends Controller
{
    private $shortenedBaseurl;

    public function __construct()
    {
        $this->shortenedBaseurl = env('APP_URL') . DIRECTORY_SEPARATOR;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'url' => ['required', 'url', 'active_url'],
        ]);
    }

    public function top()
    {
        $topUrls = ShortenedUrls::select('source_url', 'shortened_url', 'visited', 'created_at')
                                ->orderByDesc('visited')
                                ->limit(100)
                                ->get();

        if ($topUrls->isEmpty()) return view('top', ['error' => 'No shortened urls available!']);

        return view('top', ['topUrls' => $topUrls]);
    }

    public function shortenUrl(Request $request)
    {
        $this->validator($request->all())->validate();

        $shortenedUrl = new ShortenedUrls;

        $shortenedUrl->source_url = $request->url;
        $shortenedUrl->shortened_url = ShortenerHelperController::genShortenedUrl();

        if (!empty($request->nsfw) && $request->nsfw == 1) $shortenedUrl->nsfw = 1;

        $shortenedUrl->save();

        return view('shortened', ["url" => $this->shortenedBaseurl . $shortenedUrl->shortened_url]);
    }

    public function redirect($url)
    {
        if (empty($url)) return view('redirect', ['error' => 'Missing url in the request!']);

        $sourceUrl = ShortenedUrls::select('source_url', 'nsfw')
                                ->where('shortened_url', $url)
                                ->get();

        if ($sourceUrl->isEmpty()) return view('redirect', ['error' => 'The shortened url could not be found!']);

        ShortenerHelperController::incrementVisit($url);

        return view('redirect', ['nsfw' => $sourceUrl[0]->nsfw, 'redirect_url' => $sourceUrl[0]->source_url]);
    }
}
