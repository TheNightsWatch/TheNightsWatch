<?php

/**
 * 
 * @author Navarr
 * @property int ownerID
 * @property User owner
 * @property string room
 * @property DateTime created
 */
class ChatRoom extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'chat_room';
	}
	
	public function relations()
	{
		return array(
			'owner' => array(self::BELONGS_TO, 'User', 'ownerID'),
			'messages' => array(self::HAS_MANY, 'ChatMessage', 'room'),
		);
	}
}