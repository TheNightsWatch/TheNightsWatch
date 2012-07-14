<?php

class m120714_170115_create_user_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('user', array(
			'id'		=> 'INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'ign'		=> 'VARCHAR(16) NOT NULL UNIQUE COMMENT \'In Game Name\'',
			'password'	=> 'VARCHAR(60) NULL',
			'email'		=> 'VARCHAR(255) NOT NULL',
			'type'		=> "ENUM('RANGER','MAESTER','STEWARD','BUILDER')",
			'rank'		=> "ENUM('BROTHER','HEAD','COUNCIL','COMMANDER')",
			'deserter'	=> 'BOOL DEFAULT 0',
			'minezDonor'=> "ENUM('NO','SILVER','GOLD','PLATINUM')",
		));
	}

	public function safeDown()
	{
		$this->dropTable('user');
	}
}