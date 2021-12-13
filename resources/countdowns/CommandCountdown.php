<?php

use ImAMadDev\countdowns\Countdown;
use JetBrains\PhpStorm\Pure;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\player\Player;

class CommandCountdown extends Countdown {

    #[Pure] public function __construct()
    {
        parent::__construct("Command", 15, PlayerCommandPreprocessEvent::class, false);
    }

    /**
     * @param Player $player
     * @param Event $event
     * @return void
     */
    public function onUse(Player $player, Event $event) : void
    {
        if ($event instanceof PlayerCommandPreprocessEvent) {
            if ($event->getMessage() == "/help") {
                $this->onActivate($player, function (Player $player) {
                    $player->sendMessage("Closure llamado");
                });
            }
        }
    }
}