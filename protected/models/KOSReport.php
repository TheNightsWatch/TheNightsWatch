<?php

/**
 * @author Navarr
 *
 * @property int id
 * @property int kosID
 * @property int reporterID
 * @property DateTime date
 * @property string report
 * @property string proof
 * @property string server
 * @property KOS kos
 * @property User reporter
 */
class KOSReport extends ActiveRecord
{
    public static function model($c=__CLASS__) { return parent::model($c); }
    public function tableName() { return 'kos_report'; }
    
    public function relations()
    {
        return array(
            'kos' => array(self::BELONGS_TO, 'KOS', 'kosID'),
            'reporter' => array(self::BELONGS_TO, 'User', 'reporterID'),
        );
    }
}