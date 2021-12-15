<?php

namespace ImAMadDev\countdowns;

use Closure;
use ImAMadDev\CountdownMaster;
use ImAMadDev\countdowns\types\BlockProperty;
use ImAMadDev\countdowns\types\CommandProperty;
use ImAMadDev\countdowns\types\ItemProperty;
use ImAMadDev\countdowns\utils\ExtraData;
use ImAMadDev\countdowns\utils\ExtraDataType;
use pocketmine\event\Event;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;

abstract class Countdown
{

    private ?Closure $closure;

    private bool $cancelEvent = true;

    private ?array $extraData = [];

    /**
     * @param string $name
     * @param int $time
     * @param string $event
     * @param bool $storable
     */
    public function __construct(
        public string $name,
        private int $time,
        private string $event,
        private bool $storable = true)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->event;
    }

    /**
     * @return bool
     */
    public function isStorable(): bool
    {
        return $this->storable;
    }

    /**
     * @param Player $player
     * @param Event $event
     * @return void
     */
    public function onActivate(Player $player, Event $event) : void
    {
        if (!$this->canExecute($event)) return;
        $player->sendMessage(TextFormat::RED . "You have entered the " . TextFormat::GOLD . $this->getName() . TextFormat::RED . " countdown for " . gmdate('i:s', $this->getTime()));
        if($this->getClosure() !== null){
            Utils::validateCallableSignature(function(Player $player){}, $this->getClosure());
            ($this->getClosure())($player);
        }
        CountdownMaster::getInstance()->getSession($player->getName())?->addCountdown($this);
    }

    public function canExecute(Event $event) : bool
    {
        if (empty($this->extraData)) return true;
        if (isset($this->extraData[ExtraDataType::ITEM_PROPERTY])){
            $property = $this->extraData[ExtraDataType::ITEM_PROPERTY];
            if ($property instanceof ItemProperty){
                return ($property->equal($event->getItem()));
            }
        }
        if (isset($this->extraData[ExtraDataType::BLOCK_PROPERTY])){
            $property = $this->extraData[ExtraDataType::BLOCK_PROPERTY];
            if ($property instanceof BlockProperty){
                return ($property->equal($event->getBlock()));
            }
        }
        if (isset($this->extraData[ExtraDataType::COMMAND_PROPERTY])){
            $property = $this->extraData[ExtraDataType::COMMAND_PROPERTY];
            if ($property instanceof CommandProperty){
                return ($property->equal($event->getMessage()));
            }
        }
        return false;
    }

    /**
     * @return Closure
     */
    public function getClosure(): Closure
    {
        return $this->closure;
    }

    /**
     * @param Closure|null $closure
     */
    public function setClosure(?Closure $closure = null): void
    {
        $this->closure = $closure;
    }

    /**
     * @return bool
     */
    public function isCancelEvent(): bool
    {
        return $this->cancelEvent;
    }

    /**
     * @param bool $cancelEvent
     */
    public function setCancelEvent(bool $cancelEvent): void
    {
        $this->cancelEvent = $cancelEvent;
    }

    /**
     * @return array|null
     */
    public function getExtraData(): ?array
    {
        return $this->extraData;
    }

    /**
     * @param string $extraDataType
     * @param ExtraData $extraData
     */
    public function addExtraData(string $extraDataType, ExtraData $extraData): void
    {
        $this->extraData[$extraDataType] = $extraData;
    }


}