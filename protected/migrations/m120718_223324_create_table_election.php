<?php

class m120718_223324_create_table_election extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('election',array(
			'id' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'title' => 'VARCHAR(255) NOT NULL',
			'nominateStartTime' => 'TIMESTAMP NULL DEFAULT NULL',
			'startTime' => 'TIMESTAMP NULL DEFAULT NULL',
			'endTime' => 'TIMESTAMP NULL DEFAULT NULL',
		));
	}

	public function safeDown()
	{
		$this->dropTable('election');
	}
}