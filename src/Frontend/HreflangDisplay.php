<?php

namespace Trinityrank\Multilanguage\Frontend;

use Trinityrank\Multilanguage\Traits\LanguageCode;
use Illuminate\Support\Facades\Request;

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
        if( !$item ) {
            return;
        }        
        if( $item::class == null ) {
            return;
        }

        // Here we can display some default tags if there is no CONST relations between pages
        if( $item->multilang_const == null ) {
            return;
        }
        
        $html = "";
        $default_locale = config("app.locale") ?? "";

        if( class_exists($item::class) ) {
            $items = ($item::class)::where('multilang_const', $item->multilang_const)->get();
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
                if( config('app.services.'.substr(strrchr($item::class,'\\'),1).'.slug') ) {
                    $href .= config('app.services.'.substr(strrchr($item::class,'\\'),1).'.slug')."/";
                }
                //Category part
                if( config('app.services.'.substr(strrchr($item::class,'\\'),1).'.include_category_in_url') ) {
                    if( isset($item->categories->first()->slug) ) {
                        $href .= $item->categories->first()->slug ."/";
                    }
                }
                // Templated routes
                if($item->type == "route") {
                    if( Request::route()->getName() != "home" ) {
                        $href .= preg_replace('(.*?\/)', '', Request::path());
                    }
                }

                // dump($href);

                //Slug
                $href .= ($item->slug) ? $item->slug."/" : "/";

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