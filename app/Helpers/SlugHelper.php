<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SlugHelper
{
    /**
     * Return a slug that is unique in DB
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $dataToSlug
     * @return string
     */
    public static function getUniqueSlug (Model $model, string $dataToSlug) : string
    {
        // Check if the model uses the soft deletes trait
        $useSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));

        // Check if slug exists in DB
        $slug = Str::of($dataToSlug)->slug('-');
        $exists = $model->when($useSoftDeletes, function (Builder $query) {
                $query->withTrashed();
            })
            ->where('slug', $slug)
            ->count();

        // If the slug exists, execute query LIKE 'slug-%' and save the slug columns results to an array
        if ($exists > 0) {
            $slugsInDB = $model->when($useSoftDeletes, function (Builder $query) {
                    $query->withTrashed();
                })
                ->where('slug', 'LIKE', $slug . '-%')
                ->get('slug')
                ->pluck('slug')
                ->toArray();
            return static::findSlugCheckingInArray($slug, $slugsInDB);
        }

        return $slug;
    }

    /**
     * Return a slug that is part of a composite unique key in DB
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $dataToSlug
     * @param string $column
     * @return string
     */
    public static function getNonUniqueSlug (Model $model, string $dataToSlug, string $column) : string
    {
        // Check if the model uses the soft deletes trait
        $useSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));

        // Check if slug exists in DB
        $slug = Str::of($dataToSlug)->slug('-');
        $exists = $model->when($useSoftDeletes, function (Builder $query) {
                $query->withTrashed();
            })
            ->where($column, $model->{$column})
            ->where('slug', $slug)
            ->count();

        // If the slug exists, execute query LIKE 'slug-%' and save the slug columns results to an array
        if ($exists > 0) {
            $slugsInDB = $model->when($useSoftDeletes, function (Builder $query) {
                    $query->withTrashed();
                })
                ->where($column, $model->{$column})
                ->where('slug', 'LIKE', $slug . '-%')
                ->get('slug')
                ->pluck('slug')
                ->toArray();
            return static::findSlugCheckingInArray($slug, $slugsInDB);
        }

        return $slug;
    }

    /**
     * Return a bool that indicates if the slug needs to be changed in DB
     *
     * @param string $currentName
     * @param string $newName
     * @return bool
     */
    public static function checkIfSlugNeedsChange (string $currentName, string $newName) : bool
    {
        return Str::of($currentName)->slug('-') != Str::of($newName)->slug('-');
    }

    /**
     * Return a new slug, joining a counter at the end of it and checking if it exists in the array given
     *
     * @param string $slug
     * @param array<string> $slugsInDB
     * @return string
     */
    public static function findSlugCheckingInArray (string $slug, array $slugsInDB) : string
    {
        $counter = 0;

        do {
            $counter++;
            $newSlug = $slug . '-' . $counter;
            $exists = in_array($newSlug, $slugsInDB, true);
        } while ($exists);

        return $newSlug;
    }
}
