<?php

namespace ImAMadDev\countdowns;

use Closure;
use ImAMadDev\CountdownMaster;
use pocketmine\event\Event;
use pocketmine\player\Player;
use pocketmine\utils\Utils;

abstract class Countdown
{

    private ?Closure $closure;

    private bool $cancelEvent = true;

    /**
     * @param string $name
     * @param int $time
     * @param string $event
     * @param bool $storable
     */
    public function __construct(
        public string $name,
        private int $time,
        private string $event,
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
        return $this->event;
    }

    /**
     * @return bool
     */
    public function isStorable(): bool
    {
        return $this->storable;
    }

    /**
     * @param Player $player
     * @param Event $event
     * @return void
     */
    public function onActivate(Player $player, Event $event) : void
    {
        $player->sendMessage("You have been joined to the " . $this->getName() . " countdown!");
        if($this->getClosure() !== null){
            Utils::validateCallableSignature(function(Player $player){}, $this->getClosure());
            ($this->getClosure())($player);
        }
        CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this);
    }

    /**
     * @return Closure
     */
    public function getClosure(): Closure
    {
        return $this->closure;
    }

    /**
     * @param Closure|null $closure
     */
    public function setClosure(?Closure $closure = null): void
    {
        $this->closure = $closure;
    }

    /**
     * @return bool
     */
    public function isCancelEvent(): bool
    {
        return $this->cancelEvent;
    }

    /**
     * @param bool $cancelEvent
     */
    public function setCancelEvent(bool $cancelEvent): void
    {
        $this->cancelEvent = $cancelEvent;
    }


}