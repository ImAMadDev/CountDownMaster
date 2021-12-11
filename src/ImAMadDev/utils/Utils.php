<?php

namespace ImAMadDev\utils;

use pocketmine\utils\SingletonTrait;


use function microtime;

class Utils {
    use SingletonTrait;

    public function calculateMicrotime(float $time) : float
    {
        $time_stamp = microtime(true);
        return $time - $time_stamp;
    }
}