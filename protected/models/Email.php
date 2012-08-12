<?php 

/**
 * @property int id
 * @property int userID
 * @property User user
 * @property DateTime timestamp
 * @property string subject
 * @property string body
 */
class Email extends ActiveRecord
{
    public static function model($c=__CLASS__)
    {
        return parent::model($c);
    }
    
    public function tableName() { return 'email'; }
    
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO,'User','userID'),
        );
    }
}