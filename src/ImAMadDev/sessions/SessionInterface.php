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
}