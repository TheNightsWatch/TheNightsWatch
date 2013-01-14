<?php

class m120926_015808_create_table_ip extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('ip',array(
	        'uid' => 'INT UNSIGNED NOT NULL',
	        'ip' => 'VARCHAR(50) NOT NULL',
	        'PRIMARY KEY(uid,ip)',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('ip');
	}
}