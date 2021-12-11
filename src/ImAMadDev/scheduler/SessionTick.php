<?php

namespace ImAMadDev\scheduler;

use ImAMadDev\CountdownMaster;
use pocketmine\scheduler\Task;

class SessionTick extends Task
{

    public function onRun(): void
    {
        foreach (CountdownMaster::getInstance()->getSessions() as $session) {
            $session->onTick();
        }
    }
    
}
