<?php

class DenyAtFilter extends CFilter
{
    public $start;
    public $end;
    public $message;
    
    protected function preFilter($fC) {
        $now = time();
        if($now >= $this->start && $now <= $this->end)
            throw new CHttpException(503,$this->message);
        return true;
    }
    protected function postFilter($fC) {
        
    }
}