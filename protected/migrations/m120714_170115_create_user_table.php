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
			'type'		=> "ENUM('RANGER','MAESTER','STEWARD','BUILDER') NOT NULL",
			'rank'		=> "ENUM('MEMBER','HEAD','COUNCIL','COMMANDER') NOT NULL DEFAULT 'MEMBER'",
			'deserter'	=> 'BOOL DEFAULT 0',
			'minezDonor'=> "ENUM('NO','SILVER','GOLD','PLATINUM')",
			'joinDate'  => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'lastLogin' => 'TIMESTAMP NULL',
		));
	}

	public function safeDown()
	{
		$this->dropTable('user');
	}
}