<?php

class m120910_001902_create_table_log extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('log',array(
	        'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
	        'ip' => 'VARCHAR(50) NOT NULL',
	        'uri' => 'VARCHAR(255) NOT NULL',
	        'uid' => 'INT UNSIGNED NULL',
	        'time' => 'TIMESTAMP NOT NULL',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('log');
	}
}