<?php

class m120813_000755_rename_email_to_announcements extends CDbMigration
{
	public function safeUp()
	{
	    $this->renameTable('email','announcement');
	    $this->addColumn('announcement','go_public','TIMESTAMP NULL');
	    $this->addColumn('announcement','expires','TIMESTAMP NULL');
	}

	public function safeDown()
	{
	    $this->dropColumn('announcement', 'go_public');
	    $this->dropColumn('announcement', 'expires');
	    $this->renameTable('announcement','email');
	}
}