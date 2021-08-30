<?php

namespace Soulz\TimeIsMoney\task;

use onebone\economyapi\EconomyAPI;
use pocketmine\scheduler\Task;

use pocketmine\utils\Config;
use Soulz\TimeIsMoney\Loader;

class AutoPayTask extends Task {

    /** @var Loader */
    protected $loader;

    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader) {
        $this->loader = $loader;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick) {
        foreach($this->loader->getServer()->getOnlinePlayers() as $player){

                $eco = EconomyAPI::getInstance();
                $autoGain = $eco->addMoney($player);
                $this->loader->getPlayer($player)->moneyIncrease($autoGain, $this->getConfig()->get("auto-gain"));
        }
    }
}
