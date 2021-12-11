<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\Player;

class EnderPearl extends Countdown {

    public function onStart() {

        $this->getLogger()->info("Started !");
    }

    public function onJoin(Player $player) {
        $player->sendMessage("Welcome to this example UHC Scenario !");
    }
}