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


    public static function meta_tags($item)
    {
        // dd( $item );

        if( ! $item ) {
            return;
        }
        
        if( $item->multilang_const == null ) {
            return;
        }
        // dd( Route::currentRouteName() );
        // dd( Route::current()->uri );
        // dd( class_exists($item->type) );
        
        if( !$item && !isset($item->type) ) {
            return;
        }
        
        $html = "";
        $default_locale = config("app.locale") ?? "";
        // $route_name = Route::currentRouteName();

        if( class_exists($item->type) ) {
            $items = $item->type::where('multilang_const', $item->multilang_const)->get();
        }
        else {
            $items = null;
        }

        // dd( $items );

        if($items)
        {
            foreach ($items as $item)
            {
                $href = ($item->multilang_language == $default_locale) ? '' : $item->multilang_language .'/';
                
                //Fix part
                if( config('app.services.'.substr(strrchr($item->type,'\\'),1).'.slug') ) {
                    $href .= config('app.services.'.substr(strrchr($item->type,'\\'),1).'.slug')."/";
                }
                //Category part
                if( config('app.services.'.substr(strrchr($item->type,'\\'),1).'.include_category_in_url') ) {
                    if( isset($item->categories->first()->slug) ) {
                        $href .= $item->categories->first()->slug ."/";
                    }
                }
                //Slug
                $href .= ($item->slug) ? $item->slug."/" : "/";

                // dd($href);

                if( $item->multilang_language == $default_locale) {
                    $html .= "<link rel=\"alternate\" hreflang=\"x-default\" href=\"". url($href) ."\" />\n";
                    $html .= "<link rel=\"alternate\" hreflang=\"". self::iso_language_codes($item->multilang_language) ."\" href=\"". url($href) ."\" />\n";
                }
                else {
                    $html .= "<link rel=\"alternate\" hreflang=\"". self::iso_language_codes($item->multilang_language) ."\" href=\"". url($href) ."\" />\n";
                }
            }
        }

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