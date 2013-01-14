<?php

class IPLogFilter extends CFilter
{
    protected function preFilter($chain)
    {
        return true;
    }
    public function postFilter($chain)
    {
        if(Yii::app()->user->isGuest) return true;
        try {
            $request = str_replace("§",'',Yii::app()->request->getRequestUri());
            $uid = Yii::app()->user->isGuest ? NULL : Yii::app()->user->getId();
            $ip = Yii::app()->request->getUserHostAddress();
             
            $log = new LogActivity;
            $log->attributes = array(
                'uid' => $uid,
                'ip' => $ip,
            );
            $log->save();
        } catch(Exception $e) { /* MySQL Must be down */ }
    }
}
