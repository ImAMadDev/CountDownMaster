<?php

use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\Countdown;
use JetBrains\PhpStorm\Pure;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\player\Player;

class JumpCountdown extends Countdown {

    #[Pure] public function __construct()
    {
            parent::__construct("Jump", 5, false);
    }

    /**
     * @param Player $player
     * @param Event $event
     * @return void
     */
    public function onUse(Player $player, Event $event) : void
    {
        if ($event instanceof PlayerJumpEvent) {
            $this->onActivate($player, function (Player $player){
                $player->sendMessage("Closure llamado");
            });
        }
    }
}