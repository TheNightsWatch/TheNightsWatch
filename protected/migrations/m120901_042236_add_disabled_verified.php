<?php

class m120901_042236_add_disabled_verified extends CDbMigration
{
	public function safeUp()
	{
	    $this->alterColumn('user','deserter',"ENUM('NO','DESERTER','LEFT','DISABLED') NOT NULL DEFAULT 'NO'");
	    $this->addColumn('user','verified','BOOLEAN NOT NULL DEFAULT 0');
	}

	public function safeDown()
	{
	    $this->alterColumn('user','deserter',"ENUM('NO','DESERTER','LEFT') NOT NULL DEFAULT 'NO'");
	    $this->dropColumn('user','verified');
	}
}