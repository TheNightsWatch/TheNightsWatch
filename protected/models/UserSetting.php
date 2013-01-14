<?php

/**
 * User Settings
 * @author Navarr
 *
 * @property boolean email User accepts announcement emails
 */
class UserSetting extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'user_setting';
    }
}