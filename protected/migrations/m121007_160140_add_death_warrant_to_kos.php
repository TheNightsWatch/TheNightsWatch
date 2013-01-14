<?php

class m121007_160140_add_death_warrant_to_kos extends CDbMigration
{
	public function up()
	{
	    $this->alterColumn('kos','status',"ENUM('CAUTION','WARNING','ACCEPTED','DESERTER','WARRANT') DEFAULT 'CAUTION'");
	}

	public function down()
	{
		$this->alterColumn('kos','status',"ENUM('CAUTION','WARNING','ACCEPTED','DESERTER') DEFAULT 'CAUTION'");
	}
}