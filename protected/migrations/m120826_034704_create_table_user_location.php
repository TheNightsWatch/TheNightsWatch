<?php

class m120826_034704_create_table_user_location extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('user_location',array(
	        'userID' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY',
	        'x' => 'INT NULL',
	        'y' => 'INT NULL',
	        'z' => 'INT NULL',
	        'lastUpdate' => 'TIMESTAMP NULL DEFAULT NULL',
	        'server' => 'TEXT',
	        'FOREIGN KEY (userID) REFERENCES user(id)',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('user_location');
	}
}