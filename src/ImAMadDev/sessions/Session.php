<?php

namespace ImAMadDev\sessions;

use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\Countdown;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Session{

    private array $countdowns = [];

    public function __construct(
        private SessionInterface $information){}

    public function getDb() : SessionInterface {
        return $this->information;
    }

    public function getPlayer() : ?Player
    {
        return Server::getInstance()->getPlayerByPrefix($this->getDb()->getIdentifier());
    }

    public function compare(string $name) : bool
    {
        return $name == $this->information->getIdentifier();
    }

    public function addCountdown(Countdown $countdown) : void
    {
        $this->countdowns[$countdown->getName()] = $countdown->getTime();
        if ($countdown->isStorable()){
            $this->getDb()->add($countdown->getName(), $countdown->getTime());
        }
    }

    public function hasCountdown(string $name) : bool
    {
        if (!isset($this->countdowns[$name])){
            return false;
        } elseif ($this->countdowns[$name] < 1){
            return false;
        }
        return true;
    }

    public function getCountdown(string $name) : int
    {
        return $this->countdowns[$name] ?? 0;
    }

    public function onTick() : void
    {
         foreach ($this->countdowns as $name => $countdown) {
             if ($this->countdowns[$name] < 1){
                 unset($this->countdowns[$name]);
                 $this->information->update($name, 0);
                 $this->getPlayer()?->sendMessage(TextFormat::GREEN . "Your " . TextFormat::GOLD . $name . TextFormat::GREEN . " countdown has expired!");
                 continue;
             }
             $this->countdowns[$name] = $countdown -= 1;
             $this->information->update($name, $this->countdowns[$name]);
         }
    }

    public function getCountdowns() : array
    {
        return $this->countdowns;
    }

    public function __destruct()
    {
        file_put_contents(CountdownMaster::getInstance()->getDataFolder() . 'players' . DIRECTORY_SEPARATOR . $this->information->getIdentifier() . '.json', json_encode($this->getDb()->getInformation(), JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING));
    }
}