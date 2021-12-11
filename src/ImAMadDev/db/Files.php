<?php

namespace ImAMadDev\db;

use ImAMadDev\CountdownMaster;
use ImAMadDev\session\SessionInterface;
use ImAMadDev\sessions\Session;

class Files {


    public function __construct()
    {
        foreach (glob(PLAYER_FILES . '*.json') as $file) {
            $contents = json_decode(file_get_contents(PLAYER_FILES . basename($file, '.json') . '.json'), true);
            CountdownMaster::getInstance()->openSession(new Session(new SessionInterface([])));
        }
    }

    public function hasFile(string $player) : bool
    {
        return file_exists(PLAYER_FILES . $player . '.json');
    }

    public function openFile(string $player) : void
    {
        $file = fopen(PLAYER_FILES . $player . '.json', "w+");
        $data = ["identifier" => $player, "countdowns" => []];
        fwrite($file, json_encode($data, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING));
        fclose($file);
    }
}

