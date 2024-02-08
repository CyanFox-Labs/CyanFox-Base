<?php

namespace App\Services;

class ModuleIntegrationCollector
{
    protected $content = [];

    public function add($content)
    {
        $this->content = array_merge($this->content, $content);
    }

    public function getAll()
    {
        return $this->content;
    }
}
