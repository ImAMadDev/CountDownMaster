<?php

namespace ImAMadDev\countdowns;

class Countdown {

    public function __construct(
        private string $name,
        private int $defaultTime,
        private bool $storable = true)
    {}

    public function getName() : string
    {
        return $this->name;
    }
}