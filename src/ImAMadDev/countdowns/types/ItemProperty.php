<?php

namespace ImAMadDev\countdowns\types;

use ImAMadDev\countdowns\utils\ExtraData;
use pocketmine\item\Item;

class ItemProperty extends ExtraData
{

    public function __construct(
        public Item $item){}

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    public function equal(Item $item) : bool
    {
        return $this->getItem()->getId() === $item->getId() and $this->getItem()->getMeta() === $item->getMeta();
    }

}