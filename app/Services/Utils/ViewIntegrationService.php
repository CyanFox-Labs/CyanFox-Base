<?php

namespace App\Services\Utils;

use Closure;
use Illuminate\Support\Collection;

class ViewIntegrationService
{
    protected array $integrations = [];

    public function add(string $name, ...$params)
    {
        $args = func_get_args();
        array_splice($args, 0, 1);
        $this->integrations[$name][] = $args;
    }

    public function addView(string $name, string $view)
    {
        $content = view($view)->render();
        $this->add($name, $content);
    }

    public function get(?string $name = null)
    {
        $integrations = $this->integrations;
        if ($name != null) {
            if (!isset($this->menu[$name])) {
                return null;
            }
            $integrations = $this->integrations[$name];
        }

        return new Collection($integrations);
    }

    public function getAll(): array
    {
        return $this->integrations;
    }

    public function render(string $name, Closure $callback): ?string
    {
        if (!isset($this->integrations[$name])) {
            return null;
        }

        $result = '';
        foreach ($this->integrations[$name] as $integration) {
            $result .= call_user_func($callback, ...$integration);
        }

        return $result;
    }
}
