<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenedUrls extends Model
{
    use HasFactory;

    protected $table = 'shortened_urls';
}
