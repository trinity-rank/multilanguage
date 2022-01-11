<?php

namespace Trinityrank\Multilanguage\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class LanguageController extends Controller
{

    public static function get_language()
    {
        $current_language = Request::segment(1);

        if( in_array($current_language, config('app.locales')) )
        {
            return $current_language;
        }

        return null;
    }
    

    // public static function lang_route()
    // {
    //     $default_language = config('app.locale');
    //     $current_language = self::get_language();

    //     // if( $current_language != null && $current_language != $default_language )
    //     // {
    //     //     return ".lang";
    //     // }

    //     return null;
    // }

}
