<?php

namespace ImAMadDev\sessions;

final class SessionInterface {

    public function __construct(
        private array $information){
    }

    public function getIdentifier() : string
    {
        return $this->information['identifier'];
    }

    public function getInformation() : array
    {
        return $this->information;
    }

    public function add(string $name, int $time) : void
    {
        $this->information['countdowns'][$name] = $time;
    }

    public function update(string $name, int $time) : void
    {
        if (isset($this->information['countdowns'])) return;
        if ($time == 0){
            unset($this->information['countdowns'][$name]);
            return;
        }
        $this->information['countdowns'][$name] = $time;
    }
}