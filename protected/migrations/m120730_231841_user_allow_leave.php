<?php

class m120730_231841_user_allow_leave extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('user','deserter','VARCHAR(50)');
		$this->update('user',array('deserter' => 'NO'),'deserter=0');
		$this->update('user',array('deserter' => 'DESERTER'),'deserter=1');
		$this->alterColumn('user','deserter',"ENUM('NO','DESERTER','LEFT') NOT NULL DEFAULT 'NO'");
	}

	public function safeDown()
	{
		$this->alterColumn('user','deserter','VARCHAR(50)');
		$this->update('user',array('deserter' => 0),"deserter='NO'");
		$this->update('user',array('deserter' => 1),"deserter='DESERTER'");
		$this->alterColumn('user','deserter','BOOL DEFAULT 0');
	}
}