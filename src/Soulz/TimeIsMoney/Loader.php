<?php

namespace Soulz\TimeIsMoney;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerDeathEvent;
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

        $this->getScheduler()->scheduleRepeatingTask(new AutoPayTask($this), 20 * $this->getConfig()->get("auto-pay-task"));
    }

    public function onBreak(PlayerBreakEvent $event): void{
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($event->isCancelled() == false){ # Cancels any areas players can't mine (World Protection)
            $player->moneyIncrease($this->getConfig()->get("break-block-money-gain"));
            $player->sendTip(Utils::INCLINE . $this->getConfig()->get("break-block-tip"));
        }
    }

    public function onPlace(PlayerPlaceEvent $event): void{
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($event->isCancelled == false){ # Cancels any areas players can't build (World Protection)
            $player->moneyIncrease($this->getConfig()->get("place-block-money-gain"));
            $player->sendTip(Utils::INCLINE . $this->getConfig()->get("place-block-tip"));
        }
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
