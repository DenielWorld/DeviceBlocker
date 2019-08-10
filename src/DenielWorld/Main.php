<?php

namespace DenielWorld;

use pocketmine\utils\TextFormat as TF;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        if(!file_exists("config.yml")){
            $this->saveResource("config.yml");
        }
    }

    public function onPacketReceive(DataPacketReceiveEvent $event){
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        if($event->getPacket() instanceof LoginPacket){
            //1 = Android, 2 = IOS, 7 = W10
            if($event->getPacket()->clientData["DeviceOS"] == 7){
                if($cfg->get("w10") == true){
                    $event->getPlayer()->kick(TF::colorize($cfg->get("w10-kick-reason")), false, TF::colorize($cfg->get("w10-quit-message")));
                }
                elseif($cfg->get("w10") == false){
                    return false;
                }
                else {
                    return false;
                }
            }
            elseif($event->getPacket()->clientData["DeviceOS"] == 1){
                if($cfg->get("android") == true){
                    $event->getPlayer()->kick(TF::colorize($cfg->get("android-kick-reason")), false, TF::colorize($cfg->get("android-quit-message")));
                }
                elseif($cfg->get("android") == false){
                    return false;
                }
                else {
                    return false;
                }
            }
            elseif($event->getPacket()->clientData["DeviceOS"] == 2){
                if($cfg->get("ios") == true){
                    $event->getPlayer()->kick(TF::colorize($cfg->get("ios-kick-reason")), false, TF::colorize($cfg->get("ios-quit-message")));
                }
                elseif($cfg->get("android") == false){
                    return false;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
        return true;
    }
}