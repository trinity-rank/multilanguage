<?php

namespace Trinityrank\Hreflang;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class HreflangPanel
{

    public static function make($panelTitle = 'Language', $columnName = null, $targets = null, $options = null)
    {
        // Because we have conditional fields
        if( isset($options['visibility']) && $options['visibility'] == false )
        {
            return new Panel($panelTitle, []);
        }

        return new Panel($panelTitle, [
            Text::make('CONST'),

            Select::make('Language')
                ->options([
                    "en-US" => "USA",
                    "en-GB" => "Great Britain",
                    "en-ca" => "Canada",
                    "en-au" => "Australia",
                    "de" => "German",
                    "de-at" => "Austria",
                ])
        ]);
    }

}
