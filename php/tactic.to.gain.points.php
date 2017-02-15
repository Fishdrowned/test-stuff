<?php
/**
 * Find the quickest way to send Master to the top level
 *
 * Rules:
 * 1. There're NPCs in all levels
 * 2. The Master player owns 3 Slave players, each starts at 0 points in level 0
 * 3. Players can start a battle with other players or NPCs in same or lower level,
 *      or higher level if it got enough points
 * 4. The winner gain points (count the defender level), but the loser don't lose points
 * 5. If the attacker wins and the defender is in higher level, they swap position
 * 6. Each player has 6 chances to start a battle in a round
 * 7. Round restarts when every player used its chances
 *
 * Players can help players by attacking them and then losing the battle
 * Try to find the way to send the Master player to the top level with least rounds
 */
namespace Tactic;

class Player
{
    const ROLE_MASTER = 'master';
    const ROLE_SLAVE = 'slave';

    /**
     * @var static
     */
    protected static $master;
    /**
     * @var static[]
     */
    protected static $slaves = [];

    protected $name;
    protected $role;
    protected $points = 0;
    protected $level = 0;
    protected $chance = 0;

    public function __construct($name)
    {
        $this->name = $name;
        if (static::getMaster()) {
            $this->role = static::ROLE_SLAVE;
            static::$slaves[] = $this;
        } else {
            $this->role = static::ROLE_MASTER;
            static::$master = $this;
        }
    }

    public static function getAll()
    {
        return array_merge([static::getMaster()], static::getSlaves());
    }

    /**
     * @return static
     */
    public static function getMaster()
    {
        return static::$master;
    }

    /**
     * @return static[]
     */
    public static function getSlaves()
    {
        return static::$slaves;
    }

    /**
     * @return static[]
     */
    public static function getSortedSlaves()
    {
        $sortedSlaves = [];
        foreach (static::getSlaves() as $slave) {
            $sortedSlaves[static::padOrTruncate($slave->points, 0, 5) . $slave->name] = $slave;
        }
        krsort($sortedSlaves);
        return array_values($sortedSlaves);
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getChance()
    {
        return $this->chance;
    }

    public function isMaster()
    {
        return $this->role == static::ROLE_MASTER;
    }

    protected static function padOrTruncate($input, $padding, $length)
    {
        return isset($input{$length}) ? substr($input, -$length) : str_pad($input, $length, $padding, STR_PAD_LEFT);
    }

    public static function restartRound($chance)
    {
        static::getMaster()->chance = $chance;
        foreach (static::getSlaves() as $slave) {
            $slave->chance = $chance;
        }
    }
}

$levels = [
    1 => ['gains' => 150, 'threshold' => 0],
    2 => ['gains' => 200, 'threshold' => 500],
    3 => ['gains' => 300, 'threshold' => 1200],
    4 => ['gains' => 400, 'threshold' => 2500],
    5 => ['gains' => 500, 'threshold' => 4600],
    6 => ['gains' => 600, 'threshold' => 6400],
    7 => ['gains' => 700, 'threshold' => 9200],
    8 => ['gains' => 800, 'threshold' => 12400],
    9 => ['gains' => 1000, 'threshold' => 17400],
];

$battleChances = 6;

new Player('master');
new Player('slave1');
new Player('slave2');
new Player('slave3');

$rounds = 0;
$master = Player::getMaster();
while ($master->getPoints() < $levels[9]['threshold']) {
    ++$rounds;
    Player::restartRound($battleChances);
    $allChances = $battleChances * count(Player::getAll());

    // Determine who will attack first
    while ($allChances) {
        $masterLevel = $master->getLevel();
        $upperSlaves = [];
        $lowerSlaves = [];
        foreach (Player::getSortedSlaves() as $index => $slave) {
            if ($masterLevel > $slave->getLevel()) {
                $lowerSlaves[] = $slave;
            } else {
                $upperSlaves[] = $slave;
            }
        }
        --$allChances;
    }
}
