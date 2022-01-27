<?php

namespace Trinityrank\Multilanguage;

use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Multilanguage\Traits\LanguageCode;

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
            Text::make('CONST', 'multilang_const')
                ->hideFromIndex(),

            Badge::make('Language', 'multilang_language')
                ->map(LanguageCode::$badge_language_codes),

            Select::make('Language', 'multilang_language')
                ->options( config('tenants.'. Tenant::current()->name .'.locales') )
                ->default( config('tenants.'. Tenant::current()->name .'.default-locale') )
                ->onlyOnForms(),
        ]);
    }

}
