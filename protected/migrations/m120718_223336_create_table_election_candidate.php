<?php

class m120718_223336_create_table_election_candidate extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('election_candidate',array(
			'userID' => 'INT(10) UNSIGNED NOT NULL',
			'electionID' => 'INT(10) UNSIGNED NOT NULL',
			'about' => 'TEXT NULL',
			'PRIMARY KEY(userID,electionID)',
			'FOREIGN KEY (userID) REFERENCES user(id) ON DELETE CASCADE',
			'FOREIGN KEY (electionID) REFERENCES election(id) ON DELETE CASCADE',
		));
	}

	public function safeDown()
	{
		$this->dropTable('election_candidate');
	}
}