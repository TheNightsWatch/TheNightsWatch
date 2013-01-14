<?php

class m120718_223341_create_table_election_vote extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('election_vote',array(
			'electionID' => 'INT(10) UNSIGNED NOT NULL',
			'candidateID' => 'INT(10) UNSIGNED NOT NULL',
			'voterID' => 'INT(10) UNSIGNED NOT NULL',
			'PRIMARY KEY(electionID,voterID)',
			'FOREIGN KEY (electionID) REFERENCES election(id) ON DELETE CASCADE',
			'FOREIGN KEY (candidateID) REFERENCES election_candidate(userID) ON DELETE CASCADE',
			'FOREIGN KEY (voterID) REFERENCES user(id) ON DELETE CASCADE',
		));
	}

	public function safeDown()
	{
		$this->dropTable('election_vote');
	}
}