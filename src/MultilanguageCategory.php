<?php

namespace Trinityrank\Multilanguage;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Spatie\Multitenancy\Models\Tenant;

class MultilanguageCategory
{

    public static function make($fieldName, $columnName, $settings, $options = null)
    {
        // Because we have conditional fields
        if( isset($options['visibility']) && $options['visibility'] == false )
        {
            return [];
        }

        $locales = config('app.locales');
        $fields = [];
        $resource = $settings[0];
        $model = $settings[1];
        $rules = $settings[2];

        $fields[] = Text::make('CONST', 'multilang_const')
                ->hideFromIndex();

        $fields[] = Select::make('Language', 'multilang_language')
                ->options($locales)
                // ->default( "uk" ); // test line
                ->default( config('tenant-'. Tenant::current()->name .'.default-locale') );

        foreach($locales as $lang_code => $lang_name) {
            $fields[] =
                NovaDependencyContainer::make([
                    BelongsToManyField::make('Category - '. $lang_name, 'categories', $resource)
                        ->options($model::where('multilang_language', $lang_code)->get())
                        ->optionsLabel('title')
                        ->rules($rules)
                ])
                ->dependsOn('multilang_language', $lang_code);
        }

        return $fields;
    }


}
