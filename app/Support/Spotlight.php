<?php

namespace App\Support;

use Illuminate\Http\Request;

class Spotlight
{
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
