<?php

namespace Soulz\TimeIsMoney;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\utils\TextFormat;
use Soulz\TimeIsMoney\Loader;

class Command extends Commmand implements PluginIdentifiableCommand {

    public function __construct(){
        parent::__construct("timeismoney", "View Time Is Money", "/timeismoney [info, auto]", ['timemoney']);
        $this->setPermission("time.is.money.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!isset(args[0])) return $sender->sendMessage(TextFormat::RED . "Insufficient Args! " . TextFormat::GRAY . "/timeismoney [info, auto]");
        if(!$sender->hasPermission("time.is.money.command")){
            $sender->sendMessage(TextFormat::GRAY . "You do not have permission to execute this command!");
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::GRAY . "You must execute this command in-game!");
        }
        switch(args[0]){
            case "info":
                $sender->sendMessage(TextFormat::GOLD . "Time is Money " . TextFormat::GRAY . "allows players to automatically gain money from simple tasks!\n" . TextFormat::GRAY . "Execute /timeismoney [auto] to view how money is earned!");
                break;
            case "auto":
                $sender->sendMessage(TextFormat::GRAY . "Money is earned by staying online, mining, building and killing players! You can modify amounts earned via " . TextFormat::GOLD . "config" . TextFormat::GRAY . "!");
                break;
        }
        
    }

    public function getPlugin(): Plugin {
		return Loader::getInstance();
}
