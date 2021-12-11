<?php

namespace ImAMadDev\countdowns;

use ImAMadDev\CountdownMaster;
use pocketmine\utils\SingletonTrait;

class CountdownManager {
    use SingletonTrait;

    private static array $countdowns = [];

    public function __construct(){
        $this->init();
    }

    public function init() : void
    {
        $files = array_diff(scandir(CountdownMaster::getInstance()->getDataFolder() . "countdowns"), [".", ".."]);
        foreach ($files as $file) {
            if(!is_dir(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file)) {
                require(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file);
                $classn = $this->getClasses(file_get_contents(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file));
                self::$countdowns[explode("\\", $classn)[count(explode("\\", $classn)) - 1]] = $classn;
                @mkdir(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . explode("\\", $classn)[count(explode("\\", $classn)) - 1]);
            }
        }
    }
    public function getClasses(string $file) : mixed {
        $tokens = token_get_all($file);
        $class_token = false;
        foreach ($tokens as $token) {
            if (is_array($token)) {
                if ($token[0] == T_CLASS) {
                    $class_token = true;
                } else if ($class_token && $token[0] == T_STRING) {
                    return $token[1];
                }
            }
        }
        return false;
    }

    public function getCountdowns() : array
    {
        return self::$countdowns;
    }

    public function addCountdown(Countdown $countdown) : void
    {
        self::$countdowns[$countdown->getName()] = $countdown;
    }
}