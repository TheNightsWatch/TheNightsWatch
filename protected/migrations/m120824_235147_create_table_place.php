<?php

class m120824_235147_create_table_place extends CDbMigration
{
	public function safeUp()
	{
	    /**
	     * loot:
	     * 0 - None
	     * 1 - Civ
	     * 2 - Food
	     * 4 - Military
	     */
	    $this->createTable('place',array(
	        'id' => 'INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
	        'name' => 'VARCHAR(255) NOT NULL UNIQUE',
	        'type' => "ENUM('TOWN','MINOR','MAJOR','MILITARY','DUNGEON') NOT NULL DEFAULT 'TOWN'",
	        'loot' => "INT UNSIGNED NOT NULL DEFAULT 1",
	        'x' => 'INT(10) NOT NULL',
	        'y' => 'INT(10) NOT NULL',
	        'z' => 'INT(10) NOT NULL',
	        'UNIQUE KEY (x,y,z)',
        ));
	}

	public function safeDown()
	{
	    $this->dropTable('place');
	}
}