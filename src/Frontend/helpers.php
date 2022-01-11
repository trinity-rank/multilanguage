<?php

use Trinityrank\Multilanguage\Frontend\LanguageController;

/**
 * Various helper functions
 */

// Multi language route
if (! function_exists('multilang_route')) {
    function multilang_route($route, $params = null) {
        $language = LanguageController::get_language();
        // $lang_route = LanguageController::lang_route();

        // if( $lang_route != null ) {
        //     $route = $route . $lang_route;
        // }

        // if( $language != null && $params != null ) {
        if( $language != null ) {
            // Add language as first paramether
            if( is_array($params) ) {
                array_unshift($params, $language);
            }
            else {
                $params = [$language, $params];
            }
        }

        return route($route, $params);
    }
}
