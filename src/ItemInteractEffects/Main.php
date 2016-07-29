<?php
namespace ItemInteractEffects;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
class Main extends PluginBase implements Listener {
	
	####### ####### #######   #
	       #                #         #                 #
	       #                #         #######
	       #                #         #
	#######        #         #######
	# Plugin made by Kairus Dark Seeker(Twitter: @KairusDS)
	
	private $config;
	public function onLoad() {
                $this->getLogger()->info(TextFormat::YELLOW . "ItemInteractEffects by KairusDS is loading...");
       }

	public function onEnable() {
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(280 => array("on-use-tip-message" => "§bThe power of the stick has been used!", "effect-id" => 8, "effect-duration" => 1, "effect-amplifier" => 1, "Turn-off-message" => "§b§lThe power of the stick has been turned off!", "visibility" => false)));
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
                $this->getLogger()->info(TEXTFORMAT::AQUA . "ItemInteractEffects" . TEXTFORMAT::YELLOW . " Successfully loaded!");
	}
	
	public function onInteract(PlayerInteractEvent $event) {
		if($event->getAction() == PlayerInteractEvent::LEFT_CLICK_AIR || $event->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) {
			if($this->config->exists($event->getItem()->getId())) {
				$ic = $this->config->get($event->getItem()->getId());
				$player = $event->getPlayer();
				switch($player->hasEffect($ic["effect-id"])) {
					case false:
					$ticks = $ic["effect-duration"] * 20;
                                        $visible = $ic["visibility"];
					$amplifier = $ic["effect-amplifier"];
					$player->addEffect(Effect::getEffect($ic["effect-id"])->setDuration($ticks)->setAmplifier($amplifier)->setVisible($visible));
					$player->sendTip($ic["on-use-tip-message"]);
					break;
					
					case true:
					$player->removeEffect($ic["effect-id"]);
                                        $player->sendTip($ic["Turn-off-message"]);
					break;
				}
			}
		}
	}
}
