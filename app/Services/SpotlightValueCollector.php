<?php

namespace App\Services;

class SpotlightValueCollector
{
    protected $data = [];

    public function add($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function getAll()
    {
        return $this->data;
    }
}
