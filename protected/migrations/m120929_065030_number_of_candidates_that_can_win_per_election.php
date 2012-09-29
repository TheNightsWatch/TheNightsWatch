<?php

class m120929_065030_number_of_candidates_that_can_win_per_election extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('election','winnerCount','INT NOT NULL DEFAULT 1');
	}

	public function safeDown()
	{
	    $this->dropColumn('election','winnerCount');
	}
}