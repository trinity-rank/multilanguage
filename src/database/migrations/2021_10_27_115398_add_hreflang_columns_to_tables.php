<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHreflangColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('hreflang_const', )->nullable()->after("decorators");
            $table->string('hreflang_language')->nullable()->after("decorators");
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->string('hreflang_const', )->nullable()->after("decorators");
            $table->string('hreflang_language')->nullable()->after("decorators");
        });
        
        Schema::table('pages', function (Blueprint $table) {
            $table->string('hreflang_const', )->nullable()->after("decorators");
            $table->string('hreflang_language')->nullable()->after("decorators");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['hreflang_const', 'hreflang_language']);
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['hreflang_const', 'hreflang_language']);
        });
        
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['hreflang_const', 'hreflang_language']);
        });
    }
}
