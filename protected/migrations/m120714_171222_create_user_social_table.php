<?php

class m120714_171222_create_user_social_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('user_social',array(
			'userID'	=> 'INT(10) UNSIGNED NOT NULL PRIMARY KEY',
			'reddit'	=> 'VARCHAR(255) NULL UNIQUE',
			'skype'		=> 'VARCHAR(255) NULL UNIQUE',
		));
		$this->addForeignKey('userID', 'user_social', 'userID', 'user', 'id', 'CASCADE','CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('user_social');
	}
}