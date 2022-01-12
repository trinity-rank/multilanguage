<?php

namespace Trinityrank\Multilanguage\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Spatie\Multitenancy\Models\Tenant;

class FilterByLanguage extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $value == 'all' ? $query->get() : $query->where('multilang_language', $value);
    }

    public function options(Request $request)
    {
        $languages = config('tenant-'. Tenant::current()->name .'.locales') ?? [];
        return array_merge(['All' => 'all'], array_flip($languages) );
    }
}
