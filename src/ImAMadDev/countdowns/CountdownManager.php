<?php

namespace ImAMadDev\countdowns;

use ImAMadDev\CountdownMaster;

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
                $classn = $this->getClasses(file_get_contents(CountdownMaster::getInstance()->getDataFolder() . "countdowns/" . $file));
                $this->addCountdown(new $classn());
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
        if (array_key_exists($countdown->getName(), self::$countdowns)) return;
        self::$countdowns[$countdown->getName()] = $countdown;
    }
}