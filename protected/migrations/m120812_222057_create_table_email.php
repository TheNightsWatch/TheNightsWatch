<?php

class m120812_222057_create_table_email extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('email',array(
	        'id' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
	        'userID' => 'INT(10) UNSIGNED NOT NULL',
	        'timestamp' => 'TIMESTAMP NOT NULL',
	        'subject' => 'TEXT NOT NULL',
	        'body' => 'TEXT NOT NULL',
	        'FOREIGN KEY (userID) REFERENCES user(id)',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('email');
	}
}