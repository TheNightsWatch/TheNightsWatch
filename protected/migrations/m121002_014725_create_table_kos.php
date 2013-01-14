<?php

class m121002_014725_create_table_kos extends CDbMigration
{
	public function up()
	{
	    $this->createTable('kos',array(
	        'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
	        'ign' => 'VARCHAR(16) NOT NULL UNIQUE',
	        'status' => "ENUM('CAUTION','WARNING','ACCEPTED','DESERTER') DEFAULT 'CAUTION'",
        ));
	    $this->createTable('kos_report',array(
	        'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
	        'kosID' => 'INT UNSIGNED NOT NULL',
	        'reporterID' => 'INT UNSIGNED NOT NULL',
	        'date' => 'TIMESTAMP NOT NULL',
	        'report' => 'TEXT NOT NULL',
	        'server' => 'TEXT NOT NULL',
	        'proof' => 'TEXT NULL',
	        'FOREIGN KEY (kosID) REFERENCES kos(id)',
	        'FOREIGN KEY (reporterID) REFERENCES user(id)',
        ));
	    $this->execute('INSERT INTO kos (ign,status) SELECT ign,deserter FROM user WHERE deserter=\'DESERTER\'');
	}

	public function down()
	{
	    $this->dropTable('kos_report');
		$this->dropTable('kos');
	}
}