<?php


namespace NewPlayerMC\Traps;


use pocketmine\block\Block;
use pocketmine\level\Explosion;
use pocketmine\math\AxisAlignedBB;

class AquaticMineTask extends \pocketmine\scheduler\Task
{
    /** @var Block */
    public $block;
    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function onRun(int $currentTick)
    {
        $block = $this->block;
        $config = Main::getInstance()->config;

        // [Water mine]
        $count = 0;
        foreach ($block->getLevel()->getNearbyEntities(new AxisAlignedBB($block->getX() - $config->getAll()["land_mine"]["radius"], $block->getY() - $config->getAll()["land_mine"]["radius"], $block->getZ() - $config->getAll()["land_mine"]["radius"], $block->getX() + $config->getAll()["land_mine"]["radius"], $block->getY() + $config->getAll()["land_mine"]["radius"], $block->getZ() + $config->getAll()["land_mine"]["radius"])) as $entity) {
            $count++;
            if ($count >= 1) {
                $block->getLevel()->setBlock($block->asPosition(), Block::get(0, 0));
                $explosion = new Explosion($block->asPosition(), Main::getInstance()->config->getAll()["water_mine"]["explosion_force"]);
                $explosion->explodeA();
                $explosion->explodeB();
                $count = 0;
                Main::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            }
        }
    }
}