<?php

namespace ImAMadDev\countdowns;

use ImAMadDev\CountdownMaster;
use pocketmine\utils\TextFormat;

class CountdownManager {

    private static array $countdowns = [];

    private static self $instance;

    public function __construct(){
        self::$instance = $this;
        $this->init();
    }

    /**
     * @return CountdownManager
     */
    public static function getInstance(): CountdownManager
    {
        return self::$instance;
    }

    # Special thanks to Ad5001 code was inspired by https://github.com/Ad5001/UHC
    public function init() : void
    {
        $files = array_diff(scandir(CountdownMaster::getInstance()->getDataFolder() . "countdowns"), [".", ".."]);
        foreach ($files as $file) {
            if(!is_dir(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file)) {
                require_once(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file);
                $class_name = $this->getClasses(file_get_contents(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file));
                $this->addCountdown(new $class_name());
            }
        }
        CountdownMaster::getInstance()->getLogger()->info(TextFormat::GREEN . "A total of " . TextFormat::DARK_PURPLE . count($this->getCountdowns()) . TextFormat::GREEN . " countdowns have been loaded.");
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
        if (array_key_exists($countdown->getName(), self::$countdowns)) return;
        self::$countdowns[$countdown->getName()] = $countdown;
    }

    public function getCountdownByEvent(string $class) : array
    {
        $countdowns = [];
        foreach (self::$countdowns as $countdown) {
            if ($countdown->getClass() == $class){
                $countdowns[] = $countdown;
            }
        }
        return $countdowns;
    }
}