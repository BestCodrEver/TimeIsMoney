<?php

namespace Soulz\TimeIsMoney;

use pocketmine\event\Litener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use Soulz\TimeIsMoney\task\AutoPayTask;
use onebone\economyapi\EconomyAPI;

class TimeIsMoney extends PluginBase implements Listener {

     /** @var self */
    private static $instance;

    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this,$this);

        this->getScheduler()->scheduleRepeatingTask(new AutoPayTask($this), 20 * $this->getConfig()->get("auto-pay-task"));
    }

    public function onLoad(): void{
        self::$instance = $this;
    }

    /** 
    * @var Loader
    */
    public static function getInstance(): self{
        return self::$instance;
    }

}
