<?php

namespace Trinityrank\Multilanguage\Frontend;
use Trinityrank\Multilanguage\Traits\LanguageCode;

class HreflangDisplay
{
    use LanguageCode;

    public static function iso_language_codes($multilang_language)
    {
        if( isset(LanguageCode::$iso_language_codes[$multilang_language]) ) {
            return LanguageCode::$iso_language_codes[$multilang_language];
        }

        return $multilang_language;
    }


    public static function meta_tags($post, $default_locale)
    {
        if( !$post) {
            return;
        }

        $html = "";
        $items = $post->type::where('multilang_const', $post->multilang_const)->get();

        if($items)
        {
            foreach ($items as $item)
            {
                if( $item->multilang_language == $default_locale) {
                    $html .= "<link rel=\"alternate\" multilanguage=\"x-default\" href=\"/". $item->slug ."\" />\n";
                }
                $html .= "<link rel=\"alternate\" multilanguage=\"". self::iso_language_codes($item->multilang_language) ."\" href=\"/". $item->slug ."\" />\n";
            }
        }

        // dd( $html );
        
        return $html;
    }

}



/*
    "id" => 393
    "user_id" => 1
    "editor_id" => null
    "type" => "App\Articles\Types\Blog"
    "title" => "Post US 1"
    "slug" => "post-us-1"
    "excerpt" => null
    "show_toc" => 0
    "show_author" => 1
    "show_comments" => 1
    "decorators" => "[]"
    "multilang_language" => "en-us"
    "multilang_const" => "post-1-CONST"
    "status" => 1
    "created_at" => "2021-10-28 09:02:24"
    "updated_at" => "2021-10-28 09:09:05"
    "publish_at" => "2021-10-28 09:02:24"
*/