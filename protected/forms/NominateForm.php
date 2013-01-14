<?php

/**
 * NominateForm class
 * NominateForm is the data structure for keeping
 * nomination form data.  It is used by the 'nominate' action of 'ElectionController'
 */

class NominateForm extends CFormModel
{
    public $username;
    public $electionID;
    
    public function rules()
    {
        return array(
            array('username, electionID','required'),
            array('electionID','number'),
        );
    }
}