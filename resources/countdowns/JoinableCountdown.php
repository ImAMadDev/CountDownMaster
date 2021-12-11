<?php

use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\Countdown;
use JetBrains\PhpStorm\Pure;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;

class JoinableCountdown extends Countdown {

    #[Pure] public function __construct()
    {
        parent::__construct("Joinable", 15, false);
    }

    public function onActivate(Player $player, Event $event) : void {
        if ($event instanceof PlayerJoinEvent) {
            $player->sendMessage("You have used ender pearl");
            CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this->getName(), $this->getDefaultTime());
        }
    }
}