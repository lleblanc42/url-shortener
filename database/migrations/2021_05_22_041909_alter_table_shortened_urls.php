<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTableShortenedUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('shortened_urls')->truncate();

        Schema::table('shortened_urls', function (Blueprint $table) {
            $table->longText('shortened_url')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shortened_urls', function (Blueprint $table) {
            $table->longText('shortened_url')->nullable(false)->change();
        });
    }
}
