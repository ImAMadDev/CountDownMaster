<?php

use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\Countdown;
use JetBrains\PhpStorm\Pure;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

class EnderPearlCountdown extends Countdown {

    #[Pure] public function __construct()
    {
        parent::__construct("EnderPearl", 15, false);
    }

    public function onActivate(Player $player, Event $event) : void {
        if ($event instanceof PlayerItemUseEvent) {
            $item = $event->getItem();
            if ($item->getId() == ItemIds::ENDER_PEARL) {
                $player->sendMessage("You have used ender pearl");
                CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this->getName(), $this->getDefaultTime());
            }
        }
    }
}