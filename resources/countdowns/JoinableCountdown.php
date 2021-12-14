<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;

class JoinableCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("Joinable", 5, PlayerJoinEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(false);
    }

}