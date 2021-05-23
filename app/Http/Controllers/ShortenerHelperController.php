<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortenedUrls;
use Hashids\Hashids;

class ShortenerHelperController extends Controller
{
    private static $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function genShortenedUrl()
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
}
