<?php

/**
 * 
 * @author Navarr
 * @property string ip
 * @property int uid
 * @property User user
 */
class LogActivity extends ActiveRecord
{
    public static function model($class=__CLASS__)
    {
        return parent::model($class);
    }
    
    public function tableName()
    {
        return 'ip';
    }
    
    public function rules()
    {
        return array(
            array('ip, uid', 'safe', 'on' => 'insert')
        );
    }
    
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'uid'),
        );
    }
}