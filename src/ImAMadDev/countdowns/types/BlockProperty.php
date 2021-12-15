<?php

namespace ImAMadDev\countdowns\types;

use ImAMadDev\countdowns\utils\ExtraData;
use pocketmine\block\Block;

class BlockProperty extends ExtraData
{

    public function __construct(
        public Block $block){}

    /**
     * @return Block
     */
    public function getBlock(): Block
    {
        return $this->block;
    }

    public function equal(Block $block) : bool
    {
        return $this->getBlock()->getId() === $block->getId() and $this->getBlock()->getMeta() === $block->getMeta();
    }

}