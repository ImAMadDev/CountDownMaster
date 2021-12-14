<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\player\Player;

class JumpCountdown extends Countdown {

    public function __construct()
    {
            parent::__construct("Jump", 5, PlayerJumpEvent::class, false);
            $this->setClosure(function (Player $player){
                $player->sendMessage("Closure called!");
            });
            $this->setCancelEvent(true);
    }

}