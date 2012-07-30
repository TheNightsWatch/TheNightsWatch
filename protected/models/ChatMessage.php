<?php

/**
 * @property int userID
 * @property User user
 * @property ChatRoom room
 * @property DateTime timestamp
 * @property string message
 */
class ChatMessage extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'chat_message';
	}
	
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
			'room' => array(self::BELONGS_TO, 'ChatRoom', 'room'),
		);
	}
}