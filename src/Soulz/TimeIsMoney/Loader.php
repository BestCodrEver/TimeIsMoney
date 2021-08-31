<?php

namespace Soulz\TimeIsMoney;

use onebone\economyapi\EconomyAPI;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Litener;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use Soulz\TimeIsMoney\Command;
use Soulz\TimeIsMoney\task\AutoPayTask;

class Loader extends PluginBase implements Listener {

    /** @var self */
    private static $instance;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getScheduler()->scheduleRepeatingTask(new AutoPayTask($this), 20);
        $this->getServer()->getCommandMap()->registerAll("TimeIsMoney", [
            new Command()
        ]);
    }

    /**
     * @param PlayerBreakEvent $event
     * @ignoreCancelled true
     */
    public function onBreak(PlayerBreakEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($event->isCancelled() == false){
            $amount = $this->getConfig()->get("break-block-money-gain");
            EconomyAPI::getInstance()->addMoney($player, $amount);
            $player->sendTip(Utils::INCLINE . $this->getConfig()->get("break-block-tip"));
        }
    }

    /**
     * @param PlayerPlaceEvent $event
     * @ignoreCancelled true
     */
    public function onPlace(PlayerPlaceEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($event->isCancelled == false){
            $amount = $this->getConfig()->get("place-block-money-gain");
            EconomyAPI::getInstance()->addMoney($player, $amount);
            $player->sendTip(Utils::INCLINE . $this->getConfig()->get("place-block-tip"));
        }
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();
        $cause = $player->getLastDamageCause();

        if($cause instanceof EntityDamageByEntityEvent){
            if(($damager = $cause->getDamager()) instanceof Player){
                $amount = $this->getConfig()->get("kill-player-money-gain");
                EconomyAPI::getInstance()->addMoney($damager, $amount);
                $damager->sendMessage(Utils::INCLINE . $this->getConfig->get("kill-player-message"));
            }
        }
    }

    /** 
     * @var Loader
     */
    public static function getInstance(): self {
        return self::$instance;
    }

}
