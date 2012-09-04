<?php

/**
 * 
 * @author Navarr
 * @property int userID
 * @property string twitter
 * @property string skype
 * @property string reddit
 */
class SocialProfile extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_social';
	}
	
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
		);
	}
}