<?php

use ImAMadDev\countdowns\Countdown;
use ImAMadDev\countdowns\types\ItemProperty;
use ImAMadDev\countdowns\utils\ExtraDataType;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class GoldenAppleCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("GoldenApple", 30, PlayerItemConsumeEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(true);
        $this->addExtraData(ExtraDataType::ITEM_PROPERTY, new ItemProperty(VanillaItems::GOLDEN_APPLE()));
    }

}