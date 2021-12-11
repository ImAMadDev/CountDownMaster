<?php

use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\Countdown;
use JetBrains\PhpStorm\Pure;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;

class ChatCountdown extends Countdown {

    #[Pure] public function __construct()
    {
        parent::__construct("Chat", 15, false);
    }

    public function onActivate(Player $player, Event $event) : void {
        if ($event instanceof PlayerChatEvent) {
            $player->sendMessage("You have joined to chat countdown");
            CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this->getName(), $this->getDefaultTime());
        }
    }
}