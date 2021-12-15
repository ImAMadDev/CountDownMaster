<?php

namespace ImAMadDev\countdowns\types;

use ImAMadDev\countdowns\utils\ExtraData;
use pocketmine\block\Block;

class CommandProperty extends ExtraData
{

    /**
     * @param string $command_name
     */
    public function __construct(
        public string $command_name){}

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command_name;
    }

    public function equal(string $command) : bool
    {
        return $this->getCommand() == str_replace(['/', './'], [''], $command);
    }

}