<?php

class m120730_001940_create_chat_tables extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('chat_room',array(
			'room' => 'VARCHAR(255) NOT NULL PRIMARY KEY',
			'ownerID' => 'INT(10) UNSIGNED NOT NULL',
			'created' => 'TIMESTAMP NOT NULL',
			'FOREIGN KEY(ownerID) REFERENCES user(id) ON DELETE CASCADE',
		));
		
		$this->createTable('chat_message',array(
			'id' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY',
			'room' => 'VARCHAR(255) NOT NULL',
			'userID' => 'INT(10) UNSIGNED NOT NULL',
			'message' => 'TEXT NOT NULL',
			'timestamp' => 'TIMESTAMP NOT NULL',
			'FOREIGN KEY(room) REFERENCES chat_room(room) ON DELETE CASCADE ON UPDATE CASCADE',
			'FOREIGN KEY(userID) REFERENCES user(id) ON DELETE CASCADE',
		));
		
		$this->insert('chat_room',array(
			'room' => 'lobby',
			'ownerID' => 1,
		));
	}

	public function safeDown()
	{
		$this->dropTable('chat_message');
		$this->dropTable('chat_room');
	}
}