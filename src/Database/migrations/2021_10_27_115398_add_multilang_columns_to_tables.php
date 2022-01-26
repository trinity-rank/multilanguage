<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilangColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('multilang_const')->nullable()->after("decorators");
            $table->string('multilang_language')->nullable()->after("decorators");
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->string('multilang_const')->nullable()->after("decorators");
            $table->string('multilang_language')->nullable()->after("decorators");
        });
        
        Schema::table('pages', function (Blueprint $table) {
            $table->string('multilang_const')->nullable()->after("decorators");
            $table->string('multilang_language')->nullable()->after("decorators");
        });

        Schema::table('static_pages', function (Blueprint $table) {
            $table->string('multilang_const')->nullable()->after("attributes");
            $table->string('multilang_language')->nullable()->after("attributes");
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
            $table->dropColumn(['multilang_const', 'multilang_language']);
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['multilang_const', 'multilang_language']);
        });
        
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['multilang_const', 'multilang_language']);
        });
        
        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn(['multilang_const', 'multilang_language']);
        });
    }
}
