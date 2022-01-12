<?php

namespace Trinityrank\Multilanguage;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Spatie\Multitenancy\Models\Tenant;

class MultilanguagePanel
{

    public static function make($panelTitle = 'Language', $columnName = null, $targets = null, $options = null)
    {
        // Because we have conditional fields
        if( isset($options['visibility']) && $options['visibility'] == false )
        {
            return new Panel($panelTitle, []);
        }

        return new Panel($panelTitle, [
            Text::make('CONST', 'multilang_const'),
                // ->hideFromIndex(),

            Select::make('Language', 'multilang_language')
                ->options( config('tenant-'. Tenant::current()->name .'.locales') )
                ->default( config('tenant-'. Tenant::current()->name .'.default-locale') ),
        ]);
    }

}
