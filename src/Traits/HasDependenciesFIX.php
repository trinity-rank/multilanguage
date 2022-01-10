<?php

namespace Trinityrank\Multilanguage\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Epartment\NovaDependencyContainer\HasDependencies;

trait HasDependenciesFIX
{
    use HasDependencies;

    /**
     * @return bool
     */
    protected function doesRouteRequireChildFields() : bool
    {        
        return Str::endsWith(Route::currentRouteAction(), [
            'FieldDestroyController@handle',
            'ResourceUpdateController@handle',
            'ResourceStoreController@handle',
            'AssociatableController@index',
            'MorphableController@index',
            'ResourceController@index',
        ]);
    }

}
