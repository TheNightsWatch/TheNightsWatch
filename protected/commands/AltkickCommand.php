<?php

class AltkickCommand extends CConsoleCommand
{
    private static function getBlacklist()
    {
        return array('96.234.149.25','76.15.63.83','96.255.156.44','174.92.156.97','58.164.5.210','220.239.237.110','60.225.82.200','142.134.43.196','76.219.253.110','149.135.147.23','65.49.2.12','76.68.14.124','149.135.147.2','174.92.154.176','149.135.146.66','74.198.164.166','174.93.40.217','174.92.157.13','76.97.89.44','67.241.54.51','174.93.40.72','74.114.172.178','142.134.31.224','174.95.146.214','74.96.148.76','70.178.190.158','76.189.243.46');
    }
    public function run($args)
    {
        $this->startLog();
        
        $this->log("Finding all current deserters...");
        $deserters = User::model()->findAllByAttributes(array('deserter' => User::DESERTER_DESERTER));
        $deserter_uids = array();
        $deserter_emails = array();
        foreach($deserters as $deserter)
        {
            $deserter_uids[] = $deserter->id;
            $deserter_emails[] = $deserter->email;
        }
        
        $this->log("Grabbing all distinct deserter IPs");
        $deserter_ips = array();
        $criteria = new CDbCriteria();
        $criteria->addInCondition("uid",$deserter_uids);
        $ips = LogActivity::model()->findAll($criteria);
        foreach($ips as $ip) $deserter_ips[] = $ip->ip;
        CMap::mergeArray($deserter_ips, $this->getBlacklist());
        
        $new_deserter_ids = array();
        
        $this->log("Finding all other users attached to those IPs");
        $criteria = new CDbCriteria();
        $criteria->addCondition('uid IS NOT NULL');
        $criteria->addNotInCondition('uid',$deserter_uids);
        $criteria->addInCondition('ip',$deserter_ips);
        $new_uids = LogActivity::model()->findAll($criteria);
        foreach($new_uids as $new_uid) $new_deserter_ids[] = $new_uid->uid;
        
        $this->log("Finding all other users by email");
        $criteria = new CDbCriteria();
        $criteria->addInCondition('email',$deserter_emails);
        $criteria->addCondition('email IS NOT NULL');
        $criteria->addCondition('email != \'\'');
        $criteria->addNotInCondition('id',$deserter_uids);
        $new_by_email = User::model()->findAll($criteria);
        foreach($new_by_email as $new) $new_deserter_ids[] = $new->id;
        
        if(!count($new_deserter_ids)) $this->cleanDone();
        
        $this->log("Grabbing details of new deserters");
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id',$new_deserter_ids);
        $deserters = User::model()->findAll($criteria);
        
        $runner = new CConsoleCommandRunner();
        $runner->addCommands(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands');
        $runner->addCommands(Yii::getFrameworkPath().DIRECTORY_SEPARATOR.'cli'.DIRECTORY_SEPARATOR.'commands');
        foreach($deserters as $deserter)
        {
            $this->log("[{$deserter->id}] {$deserter->ign} <{$deserter->email}>");
            $runner->run(array(
                'yiic',
                'deserter',
                'add',
                "--user={$deserter->ign}",
                '--reason=User added by the Alternate Account Detection System'
            ));
        }
        $this->outputLog();
        $this->cleanLog();
    }
    
    private function startLog()
    {
        ob_start();
    }
    
    private function outputLog()
    {
        $data = ob_get_contents();
        echo $data;
    }
    
    private function log($message) { echo $message,"\n"; }
    
    private function cleanLog()
    {
        ob_end_clean();
    }
    
    private function cleanDone()
    {
        $this->cleanLog();
        Yii::app()->end(0);
    }
}