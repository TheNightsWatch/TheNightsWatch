<?php

class m120908_041624_create_minez_admin_type extends CDbMigration
{
	public function safeUp()
	{
	    $this->alterColumn('user','deserter',"ENUM('NO','DESERTER','LEFT','DISABLED','ADMIN') NOT NULL DEFAULT 'NO'");
	}

	public function safeDown()
	{
	    $this->alterColumn('user','deserter',"ENUM('NO','DESERTER','LEFT','DISABLED') NOT NULL DEFAULT 'NO'");
	}
}