<?php

namespace ImAMadDev;

use ImAMadDev\db\Files;
use ImAMadDev\sessions\{
    Session,
    SessionInterface
    };
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;


define('PLAYER_FILES', $this->getDataFolder() . DIRECTORY_SEPARATOR . 'players' . DIRECTORY_SEPARATOR);
class CountdownMaster extends PluginBase implements Listener{
    use SingletonTrait;

    private static array $sessions = [];

    public function onEnable() : void
    {
        new Files();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function openSession(Session $session = null)
    {
        if ($this->hasSession($session->getDb()->getIndetifier())) return;
        self::$sessions[spl_object_hash($session)] = $session;
    }

    public function hasSession(string $name) : bool
    {
        foreach (self::$sessions as $session) {
            if ($session->compare($name)) {
                return $session;
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
            $this->openSession(new Session(new SessionInterface([])));
        }
    }
}