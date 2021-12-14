<?php

namespace ImAMadDev\utils;

use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\SingletonTrait;


use function microtime;

class Utils {
    use SingletonTrait;

    public function calculateMicrotime(float $time) : float
    {
        $time_stamp = microtime(true);
        return $time - $time_stamp;
    }

    public function getEventByCause(int $cause) : string
    {
        return match ($cause) {
            EntityDamageEvent::CAUSE_CONTACT, EntityDamageEvent::CAUSE_SUFFOCATION, EntityDamageEvent::CAUSE_BLOCK_EXPLOSION, EntityDamageEvent::CAUSE_FIRE, EntityDamageEvent::CAUSE_LAVA => EntityDamageByBlockEvent::class,
            EntityDamageEvent::CAUSE_ENTITY_ATTACK, EntityDamageEvent::CAUSE_ENTITY_EXPLOSION, EntityDamageEvent::CAUSE_MAGIC => EntityDamageByEntityEvent::class,
            EntityDamageEvent::CAUSE_PROJECTILE => EntityDamageByChildEntityEvent::class,
            default => EntityDamageEvent::class,
        };
    }
}