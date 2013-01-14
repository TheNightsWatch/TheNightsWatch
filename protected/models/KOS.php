<?php 

/**
 * @author Navarr
 *
 * @property int id
 * @property string ign
 * @property string status
 * @property array:KOSReport reports
 */
class KOS extends ActiveRecord
{
    // KOS List Statuses
    const STATUS_CAUTION = 'CAUTION';
    const STATUS_WARNING = 'WARNING';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_DESERTER = 'DESERTER';
    const STATUS_WARRANT = 'WARRANT';
    
    public static function model($c=__CLASS__) { return parent::model($c); }
    public function tableName() { return 'kos'; }
    
    public function relations()
    {
        return array(
            'reports' => array(self::HAS_MANY, 'KOSReport', 'kosID'),
        );
    }
    
    public static function translateStatus($status)
    {
        $translations = array(
            self::STATUS_CAUTION => 'Be Wary Of',
            self::STATUS_WARNING => 'Use Caution Around',
            self::STATUS_ACCEPTED => 'Kill on Sight',
            self::STATUS_DESERTER => 'Deserters & their Alts - Kill on Sight',
            self::STATUS_WARRANT => 'A warrant has been issued for the deaths of:',
        );
        return $translations[$status];
    }
}