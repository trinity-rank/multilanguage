<?php
namespace Trinityrank\Multilanguage\Traits;

trait ScopeLanguage
{
    public function scopeLanguage($query, $lang)
    {
        $lang = $lang ?? config('app.locale');
        return $query->where('multilang_language', $lang);
    }
}
