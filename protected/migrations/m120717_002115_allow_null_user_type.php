<?php

class m120717_002115_allow_null_user_type extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('user', 'type', "enum('RANGER','MAESTER','STEWARD','BUILDER') NULL");
	}

	public function safeDown()
	{
		$this->alterColumn('user', 'type', "enum('RANGER','MAESTER','STEWARD','BUILDER') NOT NULL");
	}
}