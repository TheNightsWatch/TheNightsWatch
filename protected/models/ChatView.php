<?php

/**
 * @property int userID
 * @property User user
 * @property ChatRoom room
 * @property DateTime timestamp
 */
class ChatView extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'chat_view';
	}
	
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
			'room' => array(self::BELONGS_TO, 'ChatRoom', 'room'),
		);
	}
}