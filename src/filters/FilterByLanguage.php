<?php

namespace Trinityrank\Multilanguage\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterByLanguage extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $value == 'all' ? $query->get() : $query->where('multilang_language', $value);
    }

    public function options(Request $request)
    {
        $languages = config("app.locales") ?? [];
        return array_merge(['All' => 'all'], array_flip($languages) );
    }
}
