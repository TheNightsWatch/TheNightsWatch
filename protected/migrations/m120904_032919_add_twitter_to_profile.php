<?php

class m120904_032919_add_twitter_to_profile extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('user_social','twitter','VARCHAR(255) NULL UNIQUE');
	}

	public function safeDown()
	{
	    $this->dropColumn('user_social','twitter');
	}
}