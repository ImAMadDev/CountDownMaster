<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;

class ChatCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("Chat", 15, PlayerChatEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(true);
    }

}