<?php 

/**
 * 
 * @author Navarr
 * @property int id
 * @property string name
 * @property string type
 * @property int x
 * @property int y
 * @property int z
 * @property int loot
 * @property int color
 */
class Place extends ActiveRecord
{
    const LOOT_NONE = 0;
    const LOOT_CIV = 1;
    const LOOT_FOOD = 2;
    const LOOT_MIL = 4;
    const LOOT_WATER = 8;
    
    const TYPE_TOWN = 'TOWN';
    const TYPE_MINOR = 'MINOR';
    const TYPE_MAJOR = 'MAJOR';
    const TYPE_MIL = 'MILITARY';
    const TYPE_MILITARY = 'MILITARY';
    const TYPE_DUNGEON = 'DUNGEON';
    
    public static function model($c=__CLASS__)
    {
        return parent::model($c);
    }
    
    public function tableName()
    {
        return 'place';
    }
    
    public function has($lootType)
    {
        return $this->loot & $lootType == $lootType;
    }
    
    public function __get($var)
    {
        switch($var)
        {
            case 'color': return $this->getColor();
            default: return parent::__get($var);
        }
    }
    
    public function getColor()
    {
        if($this->type == self::TYPE_TOWN) return 0x00FF00;
        if($this->type == self::TYPE_MAJOR) return 0xFF0000;
        if($this->type == self::TYPE_MINOR) return 0x7D00FF;
        if($this->type == self::TYPE_DUNGEON) return 0x00FFFF;
    }
}