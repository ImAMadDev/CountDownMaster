<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\player\Player;

class CommandCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("Command", 15, PlayerCommandPreprocessEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(true);
    }

}