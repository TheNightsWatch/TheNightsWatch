<?php

class m121027_015503_add_user_honors extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('user','honors','INT UNSIGNED NOT NULL DEFAULT 0');
	}

	public function safeDown()
	{
	    $this->dropColumn('user', 'honors');
	}
}