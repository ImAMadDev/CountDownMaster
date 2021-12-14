<?php

use ImAMadDev\countdowns\Countdown;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Event;
use pocketmine\player\Player;

class CombatTagCountdown extends Countdown {

    public function __construct()
    {
        parent::__construct("CombatTag", 15, EntityDamageEvent::class, false);
        $this->setClosure(function (Player $player){
            $player->sendMessage("Closure called!");
        });
        $this->setCancelEvent(false);
    }

    public function onActivate(Player $player, Event $event): void
    {
        if ($event instanceof EntityDamageByEntityEvent){
            $entity = $event->getEntity();
            $attacker = $event->getDamager();
            if ($entity instanceof Player and $attacker instanceof Player){
                if (hash_equals(spl_object_hash($entity), spl_object_hash($attacker))){
                    parent::onActivate($player, $event);
                }
            }
        }
    }

}