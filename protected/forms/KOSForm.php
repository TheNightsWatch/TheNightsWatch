<?php

class KOSForm extends CFormModel
{
    public $ign;
    public $server;
    public $report;
    public $proof;

    public $id;

    public function rules()
    {
        return array(
            array('ign, server, report','required'),
            array('proof', 'safe'),
            array('ign','premium'),
            array('server','serverCheck'),
        );
    }

    public function premium($attribute,$params)
    {
        $url = "http://minecraft.net/haspaid.jsp?user=".urlencode($this->ign);
        $data = file_get_contents($url);
        if($data != "true")
        {
            $this->addError('ign','Not a valid Minecraft User');
        }
    }

    public function serverCheck($attribute,$params)
    {
        $parts = explode(".",$this->server);
        if(substr($parts[0],0,3) == "lms")
            $this->addError('server',"Night's Watch Rules do not apply on LMS Servers");
        $mineZPart = ".minez.net";
        $this->server = strtolower($this->server);
        if(substr($this->server,-1 * strlen($minezPart)) == $mineZPart)
            $this->server = substr($this->server,0,-1 * strlen($mineZPart));
    }

    public function attributeLabels()
    {
        return array(
            'ign' => 'Username',
        );
    }

    public function save()
    {
        $kos = KOS::model()->findByAttributes(array('ign' => $this->ign));
        if($kos == null)
        {
            $kos = new KOS;
            $kos->ign = $this->ign;
            $kos->save();
        }
        $report = new KOSReport;
        $report->kosID = $kos->id;
        $report->reporterID = Yii::app()->user->getId();
        $report->server = $this->server;
        $report->report = $this->report;
        $report->proof = $this->proof;
        $report->save();
        $this->id = $report->id;
        return true;
    }
}