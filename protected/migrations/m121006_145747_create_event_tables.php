<?php

class m121006_145747_create_event_tables extends CDbMigration
{
    public function up()
    {
        $this->createTable('event',array(
            'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'ip' => 'VARCHAR(16) NULL',
            'x1' => 'INT UNSIGNED NOT NULL',
            'y1' => 'INT UNSIGNED NOT NULL',
            'x2' => 'INT UNSIGNED NOT NULL',
            'y2' => 'INT UNSIGNED NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'start' => 'TIMESTAMP NOT NULL',
            'end' => 'TIMESTAMP NULL',
        ));
        $this->createTable('event_attendance',array(
            'eventID' => 'INT UNSIGNED NOT NULL',
            'userID' => 'INT UNSIGNED NOT NULL',
            'PRIMARY KEY(eventID,userID)',
            'FOREIGN KEY (eventID) REFERENCES event(id)',
            'FOREIGN KEY (userID) REFERENCES user(id)',
        ));
    }

    public function down()
    {
        $this->dropTable('event_attendance');
        $this->dropTable('event');
    }
}