<?php


namespace NewPlayerMC\Traps;



use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\utils\Config;

class Main extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener
{
    /** @var Config */
    public $config;

    private static $instance;

    public function onEnable()
    {
       $this->saveDefaultConfig();
       $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
       $this->getServer()->getPluginManager()->registerEvents($this, $this);
       self::$instance = $this;
    }

    public function onPlace(BlockPlaceEvent $event)
    {
        $block = $event->getBlock();
        if ($block->getId() == $this->config->getAll()["land_mine"]["id"] and $block->getDamage() == $this->config->getAll()["land_mine"]["meta"])
        {
            $this->getScheduler()->scheduleRepeatingTask(new LandMineTask($block), 20);
        }
        if ($block->getId() == 111)
        {
            $this->getScheduler()->scheduleRepeatingTask(new AquaticMineTask($block), 20);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }
}