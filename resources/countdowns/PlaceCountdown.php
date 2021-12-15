<?php

use ImAMadDev\countdowns\Countdown;
use ImAMadDev\countdowns\types\BlockProperty;
use ImAMadDev\countdowns\utils\ExtraDataType;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\player\Player;

class PlaceCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("Obsidian_Place", 5, BlockPlaceEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(true);
        $this->addExtraData(ExtraDataType::BLOCK_PROPERTY, new BlockProperty(VanillaBlocks::OBSIDIAN()));
    }

}