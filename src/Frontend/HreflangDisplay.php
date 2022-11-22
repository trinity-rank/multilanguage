<?php

namespace Trinityrank\Multilanguage\Frontend;

use Trinityrank\Multilanguage\Traits\LanguageCode;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use Illuminate\Support\Str;

class HreflangDisplay
{
    use LanguageCode;

    public static function iso_language_codes($multilang_language)
    {
        if (isset(LanguageCode::$iso_language_codes[$multilang_language])) {
            return LanguageCode::$iso_language_codes[$multilang_language];
        }

        return $multilang_language;
    }


    public static function href($item)
    {
        $default_locale = config("app.locale") ?? "";

        $href = ($item->multilang_language == $default_locale) ? '' : $item->multilang_language .'/';

        //Fix part
        if (config('app.services.'.substr(strrchr($item::class, '\\'), 1).'.slug')) {
            $href .= config('app.services.'.substr(strrchr($item::class, '\\'), 1).'.slug')."/";
        }
        //Category part
        if (config('app.services.'.substr(strrchr($item::class, '\\'), 1).'.include_category_in_url')) {
            if (isset($item->categories->first()->slug)) {
                $href .= $item->categories->first()->slug ."/";
            }
        }
        // Templated routes
        if ($item->type == "route") {
            if (Request::route()->getName() != "home") {
                $href .= preg_replace('(.*?\/)', '', Request::path());
            }
        }

        // Slug
        $href .= ($item->slug) ? $item->slug."/" : "/";

        return $href;
    }


    public static function meta_tags($item)
    {
        if (!$item) {
            return;
        }
        if ($item::class == null) {
            return;
        }

        $html = "";
        $default_locale = config("app.locale") ?? "";
        $region_independant = [];

        // Here we can display some default tags if there is no CONST relations between pages
        if ($item->multilang_const == null) {
            return;
        }

        if (class_exists($item::class)) {
            $items = ($item::class)::where('multilang_const', $item->multilang_const)
                ->status(1) // published
                ->get();
        } else {
            $items = null;
        }


        if ($items) {
            // Regular hreflangs
            foreach ($items as $item) {
                $href = self::href($item);
                $hreflang = self::iso_language_codes($item->multilang_language);
                $region_independant[$item->multilang_language] = $item->multilang_language;

                // Default
                if ($item->multilang_language == $default_locale) {
                    $html .= "<link rel=\"alternate\" hreflang=\"x-default\" href=\"". url($href) ."\" />\n";
                }

                // Languages
                $html .= "<link rel=\"alternate\" hreflang=\"". $hreflang ."\" href=\"". url($href) ."\" />\n";
            }

            // Region independant
            foreach ($items as $item) {
                $hreflang = self::iso_language_codes($item->multilang_language);
                $region_independant[$item->multilang_language] = $item->multilang_language;

                if (Str::contains($hreflang, "-")) {
                    $href = self::href($item);
                    $region_independant_lang = Str::of($hreflang)->explode('-');

                    if (! isset($region_independant[$region_independant_lang[0]])) {
                        $region_independant[$region_independant_lang[0]] = $region_independant_lang[0];
                        $html .= "<link rel=\"alternate\" hreflang=\"". $region_independant_lang[0] ."\" href=\"". url($href) ."\" />\n";
                    }
                }
            }
        }

        return $html;
    }
}
