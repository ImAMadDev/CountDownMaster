<?php

namespace ImAMadDev\countdowns;

use pocketmine\event\Event;
use pocketmine\player\Player;

abstract class Countdown
{

    /**
     * @param string $name
     * @param int $defaultTime
     * @param bool $storable
     */
    public function __construct(
        public string $name,
        private int $defaultTime,
        private bool $storable = true)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDefaultTime(): int
    {
        return $this->defaultTime;
    }

    /**
     * @return bool
     */
    public function isStorable(): bool
    {
        return $this->storable;
    }

    abstract public function onActivate(Player $player, Event $event) : void;

}