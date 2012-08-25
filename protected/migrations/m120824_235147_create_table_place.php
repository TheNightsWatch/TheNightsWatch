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
        // Initial Places
	    $this->insert('place',array('name' => 'Grimdale', 'x' => -1735, 'y' => 128, 'z' => 315));
	    $this->insert('place',array('name' => 'Yawpton', 'x' => -1280, 'y' => 128, 'z' => -500));
	    $this->insert('place',array('name' => 'Whitehaven', 'x' => -542, 'y' => 128, 'z' => -1096));
	    $this->insert('place',array('name' => 'Fort Erie', 'x' => 430, 'y' => 128, 'z' => -1648));
	    $this->insert('place',array('name' => 'Romero', 'x' => 1657, 'y' => 128, 'z' => 417));
	    $this->insert('place',array('name' => 'Huntsgrove', 'x' => 1032, 'y' => 128, 'z' => -26));
	    $this->insert('place',array('name' => 'Portsmouth', 'x' => -94, 'y' => 128, 'z' => 526));
	    $this->insert('place',array('name' => 'Evergreen Manor', 'x' => -354, 'y' => 128, 'z' => -396));
	    $this->insert('place',array('name' => 'Ridgevale', 'x' => 696, 'y' => 128, 'z' => -550));
	    $this->insert('place',array('name' => 'Forest', 'x' => -1560, 'y' => 128, 'z' => -1976));
	    $this->insert('place',array('name' => 'Frostbain', 'x' => -341, 'y' => 128, 'z' => -2662));
	    $this->insert('place',array('name' => 'Al Hasa', 'x' => 1600, 'y' => -100, 'z' => -3000));
	    $this->insert('place',array('name' => 'Camp Bell', 'x' => 902, 'y' => 128, 'z' => 494));
	    $this->insert('place',array('name' => 'Graveyard', 'x' => -383, 'y' => 128, 'z' => 25));
	    $this->insert('place',array('name' => 'Desert Town', 'x' => 1750, 'y' => 128, 'z' => -1210));
	    $this->insert('place',array('name' => 'Camp Kharj', 'x' => 1000, 'y' => 128, 'z' => -2600));
	    $this->insert('place',array('name' => 'Yongton Abbey', 'x' => -2110, 'y' => 128, 'z' => -1280));
	    $this->insert('place',array('name' => 'Castle Byesford', 'x' => -2400, 'y' => 128, 'z' => -3700));
	    $this->insert('place',array('name' => 'Anemos Sanctum', 'x' => 300, 'y' => 128, 'z' => -3600));
	    $this->insert('place',array('name' => 'Logging Camp', 'x' => -1100, 'y' => 128, 'z' => -940));
	    $this->insert('place',array('name' => 'Devils Castle', 'x' => -870, 'y' => 128, 'z' => -1430));
	    $this->insert('place',array('name' => 'Lorfaal Mines', 'x' => -760, 'y' => 128, 'z' => -2000));
	    $this->insert('place',array('name' => 'Carnival', 'x' => -2440, 'y' => 128, 'z' => -450));
	    $this->insert('place',array('name' => 'Farm Bell', 'x' => 825, 'y' => 128, 'z' => 400));
	    $this->insert('place',array('name' => 'Stonehenge', 'x' => 1540, 'y' => 128, 'z' => -800));
	    $this->insert('place',array('name' => 'Church of the Zombie Cult', 'x' => -1730, 'y' => 128, 'z' => -2960));
	    $this->insert('place',array('name' => 'Spire', 'x' => 680, 'y' => 128, 'z' => -185));
	    $this->insert('place',array('name' => 'Crowmure', 'x' => -1610, 'y' => 128, 'z' => -3350));
	    $this->insert('place',array('name' => 'Tiocenora & Co Quarry', 'x' => -2304, 'y' => 128, 'z' => -2668));
	    $this->insert('place',array('name' => 'Aberton', 'x' => -2400, 'y' => 128, 'z' => -1900));
	    $this->insert('place',array('name' => 'Pirate Ship','x' => 780, 'y' => 128, 'z' => -2280));
	    $this->insert('place',array('name' => 'Plains Village','x'=>1600, 'y' => 128, 'z' => 150));
	    $this->insert('place',array('name' => 'Roseluck Island','x' => 2030, 'y' => 128, 'z' => -400));
	    $this->insert('place',array('name' => 'Giant\'s Camp','x' => 680, 'y' => 128, 'z' => -3200));
	    $this->insert('place',array('name' => 'Worthington','x' => 1700,'y' => 128, 'z' => -2200));
	    $this->insert('place',array('name' => 'Fort of the Resistance','x' => 3700, 'y' => 128, 'z' => -270));
	    $this->insert('place',array('name' => 'Consilio University','x' => 100, 'y' => 128, 'z' => 100));
	    $this->insert('place',array('name' => 'Clocktower','x' => -2800, 'y' => 128, 'z' => -300));
	    $this->insert('place',array('name' => 'Stillwater Motte','x' => -2600, 'y' => 128, 'z' => -1400));
	    $this->insert('place',array('name' => 'Eillom', 'x' => 1700, 'y' => 128, 'z' => -2100));
	}

	public function safeDown()
	{
	    $this->dropTable('place');
	}
}