<?php

/**
 * 
 * @author Navarr
 * @property int id
 * @property string ip
 * @property string uri
 * @property int uid
 * @property DateTime time
 * @property User user
 */
class LogActivity extends CActiveRecord
{
    public static function model($class=__CLASS__)
    {
        return parent::model($class);
    }
    
    public function tableName()
    {
        return 'log';
    }
    
    public function rules()
    {
        return array(
            array('ip, uid, uri, time', 'safe', 'on' => 'insert')
        );
    }
    
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'uid'),
        );
    }
}