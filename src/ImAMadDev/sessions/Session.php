<?php

namespace ImAMadDev\sessions;

use ImAMadDev\session\SessionInterface;

class Session{

    private array $countdowns = [];


    public function __construct(
        private SessionInterface $information){
    }

    public function getDb() : SessionInterface {
        return $this->information;
    }

    public function compare(string $name) : bool
    {
        return $name == $this->information->getIndetifier(); 
    }

    public function addCountdown(string $name, int $time) : void
    {
        $this->countdowns[$name] = $time;
    }

    public function onTick() : void
    {
         foreach ($this->countdowns as $countdown) {
             $countdown--;
         }
    }

    public function getCountdowns() : array
    {
        return $this->countdowns;
    }

    public function __destruct()
    {
        file_put_contents(PLAYER_FILES . $this->information->getIndetifier() . '.json', JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING);
    }
}