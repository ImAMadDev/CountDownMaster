<?php

namespace ImAMadDev\session;

final class SessionInterface {

    public function __construct(
        private array $information){
    }

    public function getIndetifier() : string
    {
        return $this->information['identifier'];
    }

    public function getInformation() : array
    {
        return $this->information;
    }
}