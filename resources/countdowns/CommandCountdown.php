<?php

use ImAMadDev\countdowns\Countdown;
use ImAMadDev\countdowns\types\CommandProperty;
use ImAMadDev\countdowns\utils\ExtraDataType;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class CommandCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("Command", 15, PlayerCommandPreprocessEvent::class, false);
        $this->setCancelEvent(true);
        $this->addExtraData(ExtraDataType::COMMAND_PROPERTY, new CommandProperty("help"));
    }

}