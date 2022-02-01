<?php

namespace Trinityrank\Multilanguage;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Multilanguage\Traits\LanguageCode;
use Trinityrank\Multilanguage\Rules\LanguageConstValidation;

class MultilanguageCategory
{
    use LanguageCode;

    public static function make($fieldName, $columnName, $settings, $options = null)
    {
        // Because we have conditional fields
        if( isset($options['visibility']) && $options['visibility'] == false )
        {
            return [];
        }

        $locales_array = config('tenants.'. Tenant::current()->name .'.locales');
        $locales = [];
        $fields = [];
        $resource_category = $settings[0];
        $model_category = $settings[1];
        $model = $settings[2];
        $rules = $settings[3];
        $request = $settings[4];
        $self = $settings[5];

        // Prepare array with language code and country name for Select field
        foreach($locales_array as $lang) {
            $locales [$lang] = self::$language_names[$lang];
        }

        $fields[] = Text::make('CONST', 'multilang_const')
                ->rules(new LanguageConstValidation($request, $self, $model))
                ->hideFromIndex();

        $fields[] = Badge::make('Language', 'multilang_language')
                ->map(LanguageCode::$badge_language_codes);

        $fields[] = Select::make('Language', 'multilang_language')
                ->options($locales)
                ->default( config('tenants.'. Tenant::current()->name .'.locale') )
                ->onlyOnForms();

        foreach($locales as $lang_code => $lang_name) {
            $fields[] =
                NovaDependencyContainer::make([
                    BelongsToManyField::make('Category', 'categories', $resource_category)
                        ->options($model_category::where('multilang_language', $lang_code)->get())
                        ->optionsLabel('title')
                        ->rules($rules)
                ])
                ->dependsOn('multilang_language', $lang_code);
        }

        return $fields;
    }


}
