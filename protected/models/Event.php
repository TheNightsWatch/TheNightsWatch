<?php

/**
 * @author Navarr
 * @property int id
 * @property string ip
 * @property int x1
 * @property int y1
 * @property int x2
 * @property int y2
 * @property string name
 * @property DateTime start
 * @property DateTime end
 */
class Event extends ActiveRecord
{
    private $attendanceTable = 'event_attendance';
    public static function model($c=__CLASS__) { return parent::model($c); }
    public function tableName() { return 'event'; }
    
    public function relations()
    {
        return array(
            'attendees' => array(self::HAS_MANY,'User',"{$this->attendanceTable}(eventID,userID)"),
        );
    }
    
    public function addAttendee(User $user)
    {
        $command = Yii::app()->db->createCommand();
        $command->insert($this->attendanceTable,array(
            'userID' => $user->id,
            'eventID' => $this->id,
        ));
    }
}