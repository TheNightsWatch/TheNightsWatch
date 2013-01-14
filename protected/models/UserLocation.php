<?php

/**
 * 
 * @author Navarr
 * @property int userID
 * @property int x
 * @property int y
 * @property int z
 * @property DateTime lastUpdate
 * @property string server
 * @property User user
 */
class UserLocation extends ActiveRecord
{
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }
    
    public function tableName()
    {
    	return 'user_location';
    }
    
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO,'User','userID'),
        );
    }
    
    public function updateLocation($x,$y,$z,$server)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->server = $server;
        $this->lastUpdate = new CDbExpression('NOW()');
        return $this->save();
    }
}