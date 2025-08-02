<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class NestedEloquentFilter
{
    /**
     * Apply filters to the query based on a JSON filter array.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public static function apply(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            // Support for orWhereHas: prefix key with "or:"
            $isOr = false;
            if (strpos($key, 'or:') === 0) {
                $isOr = true;
                $key = substr($key, 3);
            }

            $segments = explode('.', $key);

            if (count($segments) === 1) {
                // Simple where on current model
                $query->where($segments[0], $value);
            } else {
                // Nested relation
                $relation = array_shift($segments);
                $nestedKey = implode('.', $segments);

                if ($isOr) {
                    $query->orWhereHas($relation, function ($q) use ($nestedKey, $value) {
                        self::apply($q, [$nestedKey => $value]);
                    });
                } else {
                    $query->whereHas($relation, function ($q) use ($nestedKey, $value) {
                        self::apply($q, [$nestedKey => $value]);
                    });
                }
            }
        }

        return $query;
    }
}