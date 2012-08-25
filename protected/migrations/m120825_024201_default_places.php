<?php

class m120825_024201_default_places extends CDbMigration
{
    public function safeUp()
    {
        $this->insert('place',array('type' => 'DUNGEON', 'name' => 'Admin Dungeon', 'x' => -285, 'y' => 60, 'z' => -2675));
        $this->insert('place',array('type' => 'DUNGEON', 'name' => 'Anemos Sanctum', 'x' => -251, 'y' => 80, 'z' => -3644));
        $this->insert('place',array('type' => 'DUNGEON', 'name' => 'Dark Mansion', 'x' => -154, 'y' => 100, 'z' => -3894));
        $this->insert('place',array('type' => 'DUNGEON', 'name' => 'Castle Byesford', 'x' => -2377, 'y' => 70, 'z' => -3739));
        $this->insert('place',array('type' => 'DUNGEON', 'name' => 'Cave of the Dying Lady', 'x' => 259, 'y' => 50, 'z' => -3330));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 6, 'name' => 'Bell Farm', 'x' => 824, 'y' => 70, 'z' => 598));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 6, 'name' => 'Evergreen Manor', 'x' => -363, 'y' => 70, 'z' => -410));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 6, 'name' => 'Church of the Zombie Cult', 'x' => -1742, 'y' => 70, 'z' => -2976));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Sacrifcial Pit to the Fire God', 'x' => -1070, 'y' => 80, 'z' => -3982));
        //$this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Random', 'x' => -2855, 'y' => 70, 'z' => -3580));
        //$this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Random', 'x' => 3620, 'y' => 70, 'z' => -1241));
        //$this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Random', 'x' => 3500, 'y' => 70, 'z' => -3414));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Consilio University', 'x' => 102, 'y' => 70, 'z' => 109));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Stonehenge', 'x' => 1538, 'y' => 70, 'z' => -866));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Devil\'s Castle', 'x' => -912, 'y' => 70, 'z' => -1424));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Lorfaal Mines', 'x' => -769, 'y' => 70, 'z' => -2012));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 1, 'name' => 'Shrine of the Dark', 'x' => 554, 'y' => 70, 'z' => -3057));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 2, 'name' => 'Farmhouse', 'x' => -2198, 'y' => 70, 'z' => 73));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 2, 'name' => 'Abandoned Farm', 'x' => 1665, 'y' => 70, 'z' => -2909));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 2, 'name' => 'Pirate Ship', 'x' => 781, 'y' => 70, 'z' => -2189));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 2, 'name' => 'Igloos', 'x' => -600, 'y' => 70, 'z' => -730));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Graveyard', 'x' => -384, 'y' => 70, 'z' => 14));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Spire', 'x' => 666, 'y' => 200, 'z' => -194));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Fort Erie', 'x' => 360, 'y' => 70, 'z' => -1711));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Logging Camp', 'x' => -1106, 'y' => 70, 'z' => -949));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Devil\'s Carnival', 'x' => -2363, 'y' => 70, 'z' => -450));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Zombie Castle', 'x' => -2021, 'y' => 100, 'z' => -741));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Anti-Zombie Castle', 'x' => -1026, 'y' => 70, 'z' => -557));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Lava Falls', 'x' => 314, 'y' => 50, 'z' => -1298));
        $this->insert('place',array('type' => 'MAJOR', 'loot' => 4, 'name' => 'Dam', 'x' => -358, 'y' => 70, 'z' => -471));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Fountain', 'x' => 1614, 'y' => 70, 'z' => -452));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Bazaar', 'x' => -516, 'y' => 70, 'z' => 328));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Tiocenora & Co Quarry', 'x' => -2288, 'y' => 70, 'z' => -2275));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Tree Fountain', 'x' => -1140, 'y' => 70, 'z' => -2800));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Eillom', 'x' => 1719, 'y' => 70, 'z' => -2084));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Al Hasa Quarry', 'x' => 1664, 'y' => 70, 'z' => -2589));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'The Pit', 'x' => -1579, 'y' => 80, 'z' => -3757));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Tower', 'x' => 16, 'y' => -70, 'z' => -556));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Admin Base', 'x' => -344, 'y' => 40, 'z' => -1755));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Central Lighthouse', 'x' => 652, 'y' => 70, 'z' => 552));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'East Lighthouse', 'x' => 1821, 'y' => 70, 'z' => 553));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'West Lighthouse', 'x' => -525, 'y' => 70, 'z' => 558));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Ice Castle', 'x' => -477, 'y' => 70, 'z' => -1747));
        $this->insert('place',array('type' => 'MINOR', 'name' => 'Hobbit Holes', 'x' => -1212, 'y' => 70, 'z' => -2442));
        $this->insert('place',array('loot' => 6, 'type' => 'TOWN', 'name' => 'Abreton', 'x' => -2491, 'y' => 70, 'z' => -1920));
        $this->insert('place',array('loot' => 6, 'type' => 'TOWN', 'name' => 'Yongton Abbey', 'x' => -2116, 'y' => 70, 'z' => -1285));
        $this->insert('place',array('loot' => 6, 'type' => 'TOWN', 'name' => 'Yawpton', 'x' => -1278, 'y' => 70, 'z' => -516));
        $this->insert('place',array('loot' => 6, 'type' => 'TOWN', 'name' => 'Crowmure', 'x' => -1595, 'y' => 70, 'z' => -3335));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Ridgevale', 'x' => 687, 'y' => 70, 'z' => -566));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Bazel', 'x' => 1751, 'y' => 70, 'z' => -1209));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Forest', 'x' => -1543, 'y' => 70, 'z' => -2011));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Clocktower', 'x' => -2821, 'y' => 70, 'z' => -343));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Stillwater Motte', 'x' => -2647, 'y' => 70, 'z' => -1420));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Worthington', 'x' => 1675, 'y' => 70, 'z' => -2159));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Gaint\'s Camp', 'x' => 691, 'y' => 70, 'z' => -3242));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Camp Azara', 'x' => 1354, 'y' => 100, 'z' => -2250));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Knox Moor', 'x' => 992, 'y' => 70, 'z' => -2018));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'Roseluck Island', 'x' => 2068, 'y' => 70, 'z' => -391));
        $this->insert('place',array('loot' => 1, 'type' => 'TOWN', 'name' => 'McLovinville', 'x' => -1325, 'y' => 70, 'z' => -1570));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Grimdale', 'x' => -1747, 'y' => 70, 'z' => 332));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Portsmouth', 'x' => -66, 'y' => 70, 'z' => 507));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Huntsgrove', 'x' => 1025, 'y' => 70, 'z' => -36));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Romero', 'x' => 1656, 'y' => 70, 'z' => 414));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Frostbain', 'x' => -324, 'y' => 70, 'z' => -2667));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Al Hasa', 'x' => -1599, 'y' => 70, 'z' => -1105));
        $this->insert('place',array('loot' => 2, 'type' => 'TOWN', 'name' => 'Whitehaven', 'x' => -529, 'y' => 70, 'z' => -1105));
        $this->insert('place',array('loot' => 4, 'type' => 'TOWN', 'name' => 'Camp Bell', 'x' => 904, 'y' => 70, 'z' => 489));
        $this->insert('place',array('loot' => 4, 'type' => 'TOWN', 'name' => 'Fort of the Resistence', 'x' => 3737, 'y' => 70, 'z' => -257));
        $this->insert('place',array('loot' => 4, 'type' => 'TOWN', 'name' => 'Camp Khari', 'x' => 974, 'y' => 70, 'z' => -2587));
    }

    public function safeDown()
    {
    }
}