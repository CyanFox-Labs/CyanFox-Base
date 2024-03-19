<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Spotlight
{
    /**
     * Gets the formatted values based on the provided admin flag.
     *
     * @param  bool  $admin  The flag indicating whether to filter based on admin role or not.
     * @return array The formatted values as an array.
     */
    public static function getFormattedValues(bool $admin)
    {
        $allValues = collect(app('spotlight.values')->getAll());

        return $allValues->filter(function ($item) use ($admin) {
            return $item['admin'] === $admin;
        })->map(function ($item) {
            return [
                'name' => $item['name'],
                'description' => $item['description'],
                'link' => route($item['route']),
                'icon' => $item['icon'],
                'admin' => $item['admin'],
            ];
        })->values()->toArray();
    }

    /**
     * Searches for values based on the provided search term.
     *
     * @param  Request  $request  The HTTP request object.
     * @return array The filtered and formatted values.
     */
    public function search(Request $request)
    {
        if (!auth()->user()) {
            return [];
        }

        $search = strtolower($request->search);
        $allValues = collect(array_merge(self::getFormattedValues(false), self::getFormattedValues(true)));

        return $allValues->filter(function ($item) use ($search) {
            return str_contains(strtolower($item['name']).strtolower($item['description']), $search);
        })->values();
    }

    /**
     * Perform actions based on given search string
     *
     * @param  string  $search  The search string to filter the actions
     * @return Collection The filtered actions
     */
    public function actions(string $search = '')
    {
        $adminValues = [];

        if (auth()->user()->hasRole('Super Admin')) {
            $adminValues = self::getFormattedValues(true);
        }

        $values = self::getFormattedValues(false);

        return collect(array_merge($values, $adminValues))->filter(fn (array $item) => str($item['name'].$item['description'])->contains($search, true));
    }
}
