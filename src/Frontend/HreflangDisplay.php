<?php

namespace Trinityrank\Multilanguage\Frontend;

class HreflangDisplay
{

    public static $iso_language_codes = [
        "ae" => "ar-ae", //	Arabic (U.A.E.)
        "af" => "af", //	Afrikaans
        "ar" => "es-ar", //	Spanish (Argentina)
        "at" => "de-at", //	German (Austria)
        "au" => "en-au", //	English (Australia)
        "be" => "nl-be", //	Belgium
        "bg" => "bg", //	Bulgarian
        "bh" => "ar-bh", //	Arabic (Bahrain)
        "bo" => "es-bo", //	Spanish (Bolivia)
        "br" => "pt-br", //	Portuguese (Brazil)
        "bz" => "en-bz", //	English (Belize)
        "ca" => "en-ca", //	Canada
        "ch" => "fr-ch", //	Switzerland
        "cl" => "es-cl", //	Spanish (Chile)
        "cn" => "zh-cn", //	Chinese (PRC)
        "co" => "es-co", //	Spanish (Colombia)
        "cr" => "es-cr", //	Spanish (Costa Rica)
        "cs" => "cs", //	Czech
        "cy" => "cy", //	Welsh
        "da" => "da", //	Danish
        "de" => "de", //	German (Standard)
        "do" => "es-do", //	Spanish (Dominican Republic)
        "dz" => "ar-dz", //	Arabic (Algeria)
        "ec" => "es-ec", //	Spanish (Ecuador)
        "eg" => "ar-eg", //	Arabic (Egypt)
        "el" => "el", //	Greek
        "en" => "en", //	English
        "es" => "es", //	Spanish (Spain)
        "et" => "et", //	Estonian
        "eu" => "eu", //	Basque
        "fa" => "fa", //	Farsi
        "fi" => "fi", //	Finnish
        "fo" => "fo", //	Faeroese
        "fr" => "fr", //	French 
        "ga" => "ga", //	Irish
        "gd" => "gd", //	Gaelic (Scotland)
        "gt" => "es-gt", //	Spanish (Guatemala)
        "he" => "he", //	Hebrew
        "hi" => "hi", //	Hindi
        "hk" => "zh-hk", //	Chinese (Hong Kong)
        "hn" => "es-hn", //	Spanish (Honduras)
        "hu" => "hu", //	Hungarian
        "id" => "id", //	Indonesian
        "ie" => "en-ie", //	English (Ireland)
        "iq" => "ar-iq", //	Arabic (Iraq)
        "is" => "is", //	Icelandic
        "it" => "it", //	Italian (Standard)
        "ja" => "ja", //	Japanese
        "ji" => "ji", //	Yiddish
        "jm" => "en-jm", //	English (Jamaica)
        "jo" => "ar-jo", //	Arabic (Jordan)
        "ko" => "ko", //	Korean
        "ku" => "ku", //	Kurdish
        "kw" => "ar-kw", //	Arabic (Kuwait)
        "lb" => "ar-lb", //	Arabic (Lebanon)
        "li" => "de-li", //	German (Liechtenstein)
        "lt" => "lt", //	Lithuanian
        "lu" => "fr-lu", //	French (Luxembourg)
        "lu" => "de-lu", //	German (Luxembourg)
        "lv" => "lv", //	Latvian
        "ly" => "ar-ly", //	Arabic (Libya)
        "ma" => "ar-ma", //	Arabic (Morocco)
        "md" => "ru-md", //	Russian (Republic of Moldova)
        "mk" => "mk", //	Macedonian (FYROM)
        "ml" => "ml", //	Malayalam
        "ms" => "ms", //	Malaysian
        "mt" => "mt", //	Maltese
        "mx" => "es-mx", //	Spanish (Mexico)
        "nb" => "nb", //	Norwegian (Bokmål)
        "ni" => "es-ni", //	Spanish (Nicaragua)
        "nl" => "nl", //	Dutch (Standard)
        "nn" => "nn", //	Norwegian (Nynorsk)
        "no" => "no", //	Norwegian
        "nz" => "en-nz", //	English (New Zealand)
        "om" => "ar-om", //	Arabic (Oman)
        "pa" => "es-pa", //	Spanish (Panama)
        "pe" => "es-pe", //	Spanish (Peru)
        "pl" => "pl", //	Polish
        "pr" => "es-pr", //	Spanish (Puerto Rico)
        "pt" => "pt", //	Portuguese (Portugal)
        "py" => "es-py", //	Spanish (Paraguay)
        "qa" => "ar-qa", //	Arabic (Qatar)
        "rm" => "rm", //	Rhaeto-Romanic
        "ro" => "ro", //	Romanian
        "ru" => "ru", //	Russian
        "sa" => "ar-sa", //	Arabic (Saudi Arabia)
        "sb" => "sb", //	Sorbian
        "sg" => "zh-sg", //	Chinese (Singapore)
        "sk" => "sk", //	Slovak
        "sl" => "sl", //	Slovenian
        "sq" => "sq", //	Albanian
        "sr" => "sr", //	Serbian
        "sv" => "es-sv", //	Spanish (El Salvador)
        "sv" => "sv", //	Swedish
        "sy" => "ar-sy", //	Arabic (Syria)
        "th" => "th", //	Thai
        "tn" => "ar-tn", //	Arabic (Tunisia)
        "tr" => "tr", //	Turkish
        "ts" => "ts", //	Tsonga
        "tt" => "en-tt", //	English (Trinidad)
        "tw" => "zh-tw", //	Chinese (Taiwan)
        "ua" => "ua", //	Ukrainian
        "uk" => "en-gb", //	English (United Kingdom)
        "ur" => "ur", //	Urdu
        "us" => "en-us", //	English (United States)
        "uy" => "es-uy", //	Spanish (Uruguay)
        "ve" => "es-ve", //	Spanish (Venezuela)
        "ve" => "ve", //	Venda
        "vi" => "vi", //	Vietnamese
        "xh" => "xh", //	Xhosa
        "ye" => "ar-ye", //	Arabic (Yemen)
        "za" => "en-za", //	English (South Africa)
        "zu" => "zu", //	Zulu
    ];


    public static function iso_language_codes($multilang_language)
    {
        if( isset(self::$iso_language_codes[$multilang_language]) ) {
            return self::$iso_language_codes[$multilang_language];
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