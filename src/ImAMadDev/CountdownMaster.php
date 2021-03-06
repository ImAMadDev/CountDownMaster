<?php

namespace ImAMadDev;

use ImAMadDev\countdowns\CountdownManager;
use ImAMadDev\db\Files;
use ImAMadDev\scheduler\SessionTick;
use ImAMadDev\sessions\SessionInterface;
use ImAMadDev\sessions\Session;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class CountdownMaster extends PluginBase implements Listener{

    private static array $sessions = [];

    public static Files $files;

    private static self $instance;

    protected function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable() : void
    {
        @mkdir($this->getDataFolder() . "players/");
        @mkdir($this->getDataFolder() . "countdowns/");
        self::$files = new Files();
        new CountdownManager();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new SessionTick(), 20);
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }


    public function openSession(Session $session = null)
    {
        if ($this->hasSession($session->getDb()->getIdentifier())) return;
        self::$sessions[spl_object_hash($session)] = $session;
    }

    public function hasSession(string $name) : bool
    {
        foreach (self::$sessions as $session) {
            if ($session->compare($name)) {
                return true;
            }
        }
        return false;
    }

    public function getSession(string $name) : ?Session
    {
        foreach (self::$sessions as $session) {
            if ($session->compare($name)) {
                return $session;
            }
        }
        return null;
    }

    public function getSessions() : array
    {
        return self::$sessions;
    }

    public function onJoin(PlayerJoinEvent $event) : void
    {
        if (!$this->hasSession($event->getPlayer()->getName())) {
            self::$files->openFile($event->getPlayer()->getName());
            $this->openSession(new Session(new SessionInterface(["identifier" => $event->getPlayer()->getName(), "countdowns" => []])));
        }
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }
    
    public function onItemUseEvent(PlayerItemUseEvent $event) : void {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));

                }
                continue;
            }
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }

    public function onChat(PlayerChatEvent $event) : void
    {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));
                }
                continue;
            }
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }

    public function onCommandUse(PlayerCommandPreprocessEvent $event) : void
    {
        if ($event->isCancelled()) return;
        if (str_starts_with($event->getMessage(), "/") or str_starts_with($event->getMessage(), "./")) {
            foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
                if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())) {
                    if ($countdown->isCancelEvent() and $countdown->canExecute($event)) {
                        $event->cancel();
                        $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));
                    }
                    continue;
                }
                $countdown->onActivate($event->getPlayer(), $event);
            }
        }
    }

    public function onEntityDamage(EntityDamageEvent $event) : void
    {
        if ($event->isCancelled()) return;
        if (!$event->getEntity() instanceof Player) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getEntity()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getEntity()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getEntity()->getName())?->getCountdown($countdown->getName()));
                }
                continue;
            }
            $countdown->onActivate($event->getEntity(), $event);
        }
    }

    public function onPlace(BlockPlaceEvent $event) : void
    {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));
                }
                continue;
            }
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }

    public function onBreak(BlockBreakEvent $event) : void
    {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));
                }
                continue;
            }
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }

    public function onEat(PlayerItemConsumeEvent $event) : void
    {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdownByEvent(get_class($event)) as $countdown) {
            if ($this->getSession($event->getPlayer()->getName())?->hasCountdown($countdown->getName())){
                if ($countdown->isCancelEvent()) {
                    $event->cancel();
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You are still on countdown for " . TextFormat::GOLD . $countdown->getName() . TextFormat::RED . " for another " . $this->getSession($event->getPlayer()->getName())?->getCountdown($countdown->getName()));
                }
                continue;
            }
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }
}
