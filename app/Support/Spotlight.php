<?php

namespace App\Support;

use Blade;
use Illuminate\Http\Request;

class Spotlight
{

    public function search(Request $request)
    {
        if(!auth()->user()) {
            return [];
        }

        return collect()
            ->merge($this->actions($request->search));
    }

    public function actions(string $search = '')
    {

        $adminValues = [];

        if (auth()->user()->hasRole('Super Admin')) {
            $adminValues = [
                [
                    'name' => __('navigation/spotlight.admin.users.create.title'),
                    'description' => __('navigation/spotlight.admin.users.create.description'),
                    'link' => '/users/create'
                ],
            ];
        }

        $defaultValues = [
            [
                'name' => __('navigation/spotlight.default.profile.title'),
                'description' => __('navigation/spotlight.default.profile.description'),
                'icon' => Blade::render('<img src="' . auth()->user()->getAvatarURL() . '" alt="Profile" class="w-9 h-9">'),
                'link' => '/profile'
            ],
            [
                'name' => __('navigation/spotlight.default.logout.title'),
                'description' => __('navigation/spotlight.default.logout.description'),
                'icon' => Blade::render('<i class="icon-log-out text-3xl"></i>'),
                'link' => route('auth.logout')
            ],
        ];

        return collect(array_merge($defaultValues, $adminValues))->filter(fn(array $item) => str($item['name'] . $item['description'])->contains($search, true));
    }

}
