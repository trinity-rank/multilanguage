<?php

namespace Trinityrank\Multilanguage\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Multilanguage\Traits\LanguageCode;

class FilterByLanguage extends Filter
{
    use LanguageCode;

    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $value == 'all' ? $query->get() : $query->where('multilang_language', $value);
    }

    public function options(Request $request)
    {
        // Prepare array with language code and country name for Select field
        $locales = [];
        $locales_array = config('tenants.'. Tenant::current()->name .'.locales') ?? [];
        foreach($locales_array as $lang) {
            $locales [$lang] = self::$language_names[$lang];
        }

        // $languages = config('tenants.'. Tenant::current()->name .'.locales') ?? [];
        return array_merge(['All' => 'all'], array_flip($locales) );
    }
}
