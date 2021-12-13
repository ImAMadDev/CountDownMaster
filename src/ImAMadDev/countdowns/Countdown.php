<?php

namespace ImAMadDev\countdowns;

use Closure;
use ImAMadDev\CountdownMaster;
use pocketmine\event\Event;
use pocketmine\player\Player;
use pocketmine\utils\Utils;

abstract class Countdown
{

    /**
     * @param string $name
     * @param int $time
     * @param string $class
     * @param bool $storable
     */
    public function __construct(
        public string $name,
        private int $time,
        private string $class,
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
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return bool
     */
    public function isStorable(): bool
    {
        return $this->storable;
    }

    public function onActivate(Player $player, ?Closure $closure = null) : void
    {
        $player->sendMessage("You have been joined to the " . $this->getName() . " countdown!");
        if($closure !== null){
            Utils::validateCallableSignature(function(Player $player){}, $closure);
            ($closure)($player);
        }
        CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this);
    }

    abstract public function onUse(Player $player, Event $event) : void;


}