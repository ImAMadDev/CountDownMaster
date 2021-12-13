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
        parent::__construct("Chat", 15, PlayerChatEvent::class, false);
    }

    /**
     * @param Player $player
     * @param Event $event
     * @return void
     */
    public function onUse(Player $player, Event $event) : void
    {
        if ($event instanceof PlayerChatEvent) {
            $this->onActivate($player, function (Player $player){
                $player->sendMessage("Closure llamado");
            });
        }
    }
}