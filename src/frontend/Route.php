<?php

namespace Trinityrank\Multilanguage\Frontend;

use Illuminate\Support\Facades\Route as LaravelRoute;
use Trinityrank\Multilanguage\Frontend\LanguageController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;


class Route extends LaravelRoute
{

    public static function multilanguage($path, $controller)
    {
        $language = LanguageController::get_language();
        $path = $language ? '{lang}/'.$path : $path;
        
        return Route::get($path, function(... $params) use ($controller, $language) {

            // If current url have default lang, than redirect to default url without lang code
            if( $language == config('app.locale') ) {
                $redirect_path = str_replace($language."/", "", Request::path());
                return Redirect::to($redirect_path, 301);
            }

            // Because "lang" is optional, we switch it from first to last place in slug paramether
            $class = $controller[0];
            $method = $controller[1];

            if( $language != null ) {
                $param_lang = $params[0];
                array_shift($params);
                $params[] = $param_lang;
            }
            else {
                $params[] = config('app.locale');
            }

            return (new $class())->$method( ... $params);
        });
    }

}
