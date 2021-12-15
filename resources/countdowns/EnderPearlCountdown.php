<?php

use ImAMadDev\countdowns\Countdown;
use ImAMadDev\countdowns\types\ItemProperty;
use ImAMadDev\countdowns\utils\ExtraDataType;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class EnderPearlCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("EnderPearl", 15, PlayerItemUseEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(true);
        $this->addExtraData(ExtraDataType::ITEM_PROPERTY, new ItemProperty(VanillaItems::ENDER_PEARL()));
    }

    public function onActivate(Player $player, Event $event): void
    {
        if ($event instanceof PlayerItemUseEvent){
            if($event->getItem()->getId() === ItemIds::ENDER_PEARL){
                parent::onActivate($player, $event);
            }
        }
    }

}