<?php

namespace ImAMadDev;

use ImAMadDev\countdowns\CountdownManager;
use ImAMadDev\db\Files;
use ImAMadDev\sessions\SessionInterface;
use ImAMadDev\sessions\Session;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

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
        $this->saveResource($this->getDataFolder() . "countdowns/EnderPearlCountdownCountdown.php", false);
        self::$files = new Files();
        new CountdownManager();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
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
    }
    
    public function onItemUseEvent(PlayerItemUseEvent $event) : void {
        if ($event->isCancelled()) return;
        foreach (CountdownManager::getInstance()->getCountdowns() as $countdown) {
            $countdown->onActivate($event->getPlayer(), $event);
        }
    }
}