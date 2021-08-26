<?php

namespace Soulz\TimeIsMoney\task;

use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use Soulz\TimeIsMoney\Loader;
use onebone\economyapi\EconomyAPI;

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
            if($this->loader->getPlayer($player) !== null){
                # This is different from what I usually do, so hopefully it works
                $this->loader->getPlayer($player) = EconomyAPI::getInstance()->addMoney($player, $this->loader->getConfig()->get("money-gain"));
            }
        }
    }
}
