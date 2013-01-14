<?php

class m120929_063729_allow_more_than_one_vote_per_election extends CDbMigration
{
	public function safeUp()
	{
	    $this->rename();
	    $this->createTable('election_vote',array(
	        'electionID' => 'INT UNSIGNED NOT NULL',
	        'candidateID' => 'INT UNSIGNED NOT NULL',
	        'voterID' => 'INT UNSIGNED NOT NULL',
	        'PRIMARY KEY (electionID,candidateID,voterID)',
	        'FOREIGN KEY (electionID) REFERENCES election(id) ON DELETE CASCADE',
	        'FOREIGN KEY (candidateID) REFERENCES election_candidate(userID) ON DELETE CASCADE',
	        'FOREIGN KEY (voterID) REFERENCES user(id) ON DELETE CASCADE',
        ));
	    $this->copyAndDrop();
	}

	public function safeDown()
	{
	    require_once(dirname(__FILE__).'/m120718_223341_create_table_election_vote.php');
	    $this->rename();
	    $temp = new m120718_223341_create_table_election_vote;
	    $temp->safeUp();
        $this->copyAndDrop();
	}
	
	private function rename()
	{
	    $this->renameTable('election_vote','temp_election_vote');
	}
	
	private function copyAndDrop()
	{
	    $this->execute('INSERT INTO election_vote SELECT * FROM temp_election_vote');
	    $this->dropTable('temp_election_vote');
	}
}