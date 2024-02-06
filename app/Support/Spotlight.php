<?php

namespace App\Support;

use App\Models\SpotlightValue;
use Blade;
use Illuminate\Http\Request;

class Spotlight
{

    public static function getFormattedValues(bool $admin)
    {
        return SpotlightValue::where('admin', $admin)
            ->get()
            ->map(function ($value) {
                return [
                    'name' => __($value->title),
                    'description' => __($value->description),
                    'icon' => Blade::render($value->icon),
                    'link' => route($value->route)
                ];
            })
            ->toArray();
    }

    public function search(Request $request)
    {
        if (!auth()->user()) {
            return [];
        }

        $search = $request->search;
        $allValues = collect(array_merge(self::getFormattedValues(false), self::getFormattedValues(true)));

        return $allValues->filter(function ($item) use ($search) {
            return str_contains($item['name'] . $item['description'], $search);
        })->values();
    }

    public function actions(string $search = '')
    {
        $adminValues = [];

        if (auth()->user()->hasRole('Super Admin')) {
            $adminValues = self::getFormattedValues(true);
        }

        $values = self::getFormattedValues(false);

        return collect(array_merge($values, $adminValues))->filter(fn(array $item) => str($item['name'] . $item['description'])->contains($search, true));
    }

}
