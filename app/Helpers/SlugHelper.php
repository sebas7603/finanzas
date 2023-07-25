<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugHelper
{
    /**
     * Return a slug that is part of a composite key in DB
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $dataToSlug
     * @param string $column
     * @param string $value
     * @return string
     */
    public static function getNonUniqueSlug (Model $model, string $dataToSlug, string $column) : string
    {
        // Chack if slug exists in DB
        $slug = Str::of($dataToSlug)->slug('-');
        $exists = $model->where($column, $model->{$column})->where('slug', $slug)->count();

        // If the slug exists, execute query LIKE 'slug-%' and save the slug columns results to an array
        if ($exists > 0) {
            $counter = 0;
            $slugsInDB = $model->where($column, $model->{$column})->where('slug', 'LIKE', $slug . '-%')->get('slug')->pluck('slug')->toArray();

            // Create a new slug, joining the counter at the end of it and check if it exists in the results array
            do {
                $counter++;
                $newSlug = $slug . '-' . $counter;
                $exists = in_array($newSlug, $slugsInDB, true);
            } while ($exists);

            return $newSlug;
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
}
