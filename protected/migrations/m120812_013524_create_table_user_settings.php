<?php

class m120812_013524_create_table_user_settings extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('user_setting',array(
	        'userID' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY',
	        'email' => "BOOL NOT NULL DEFAULT 1 COMMENT 'Send the user Emails'",
	        'FOREIGN KEY (userID) REFERENCES user(id)',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('user_setting');
	}
}