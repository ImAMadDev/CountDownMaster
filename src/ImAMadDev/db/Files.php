<?php

namespace ImAMadDev\db;

use ImAMadDev\CountdownMaster;
use ImAMadDev\sessions\SessionInterface;
use ImAMadDev\sessions\Session;
use JetBrains\PhpStorm\Pure;


class Files {

    public function __construct()
    {
        foreach (glob(CountdownMaster::getInstance()->getDataFolder() . 'players' . DIRECTORY_SEPARATOR . '*.json') as $file) {
            $contents = json_decode(file_get_contents(CountdownMaster::getInstance()->getDataFolder() . 'players' . DIRECTORY_SEPARATOR . basename($file, '.json') . '.json'), true);
            CountdownMaster::getInstance()->openSession(new Session(new SessionInterface($contents)));
        }
    }

    #[Pure] public function hasFile(string $player) : bool
    {
        return file_exists(CountdownMaster::getInstance()->getDataFolder() . 'players' . DIRECTORY_SEPARATOR . $player . '.json');
    }

    public function openFile(string $player) : void
    {
        $file = fopen(CountdownMaster::getInstance()->getDataFolder() . 'players' . DIRECTORY_SEPARATOR . $player . '.json', "w+");
        $data = ["identifier" => $player, "countdowns" => []];
        fwrite($file, json_encode($data, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING));
        fclose($file);
    }
}

