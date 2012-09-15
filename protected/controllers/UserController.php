<?php

class UserController extends Controller
{
    public function filters()
    {
        return array(
            array(
                'IPLogFilter'
            ),
        );
    }
    
    private function blackList()
    {
        return array('142.134.43.196');
    }

    public function actionIndex()
    {
        $this->setPageTitle('Member List');
        $brothers = User::model()->findAllByAttributes(array('deserter' => 'NO', 'verified' => 1));
        $this->render('index',array('users' => $brothers));
    }

    public function actionHead($unique,$size = 16)
    {
        if(intval($unique)) $unique = User::model()->findByPk($unique)->ign;
        $this->redirect(User::getHead($unique,$size),true,301);
    }

    private function capeBailOrUser($user)
    {
        $user = User::model()->findByAttributes(array('ign' => $user));
        if(!$user)
        {
            throw new CHttpException(404,"No Such User");
        }
        if(!$user->verified)
        {
            throw new CHttpException(404,"User Not Verified");
        }
        if($user->deserter == User::DESERTER_LEFT)
        {
            throw new CHttpException(404,"No Longer a Member");
        }
        if($user->deserter == User::DESERTER_DISABLED)
        {
            throw new CHttpException(404,"Account Disabled");
        }
        if($user->deserter == User::DESERTER_ADMIN)
        {
            throw new CHttpException(404,"User not really a member");
        }
        return $user;
    }

    private function filterOutStyleCodes(&$text)
    {
        $text = preg_replace("/§[a-f0-9]/iu",'',$text);
        return $text;
    }

    public function actionCapeHead($unique)
    {
        $this->filterOutStyleCodes($unique);
        try {
            if(!in_array(Yii::app()->request->getUserHostAddress(),$this->blackList()))
            	$this->capeBailOrUser($unique);
            header("HTTP/1.1 200 OK");
        } catch(CHttpException $e) {
            // search to see if its been requested by the same IP lately
            // if so, header 200
            // else 404
            $request = str_replace("§",'',Yii::app()->request->getRequestUri());
            $ip = Yii::app()->request->getUserHostAddress();
            $log = LogActivity::model()->findByAttributes(array(
                'uri' => $request,
                'ip' => $ip,
            ),array('order' => 'time DESC'));
            if($log && $log->time->getTimestamp() + 60 > time())
            {
                header("HTTP/1.1 200 OK");
            } else {
                $test = new IPLogFilter;
                $test->postFilter(null);
                throw new CHttpException($e->statusCode,$e->getMessage());
            }
        }
    }

    public function actionCape($unique)
    {
        $this->filterOutStyleCodes($unique);
        $oldMod = false;
	if(in_array(Yii::app()->request->getUserHostAddress(),$this->blackList())) $oldMod = true;
        try {
            $user = $this->capeBailOrUser($unique);
        } catch(Exception $e) {
            $oldMod = true;
        }
        Yii::app()->session->close();
        header("Content-Type: image/png");
        $file = "";
        if($oldMod) $file = 'nw-update';
        elseif($user->deserter == 'DESERTER') $file = 'deserter-cape';
        elseif($user->rank == 'COMMANDER') $file = 'commander-cape';
        elseif($user->rank == 'HEAD' && $user->type == 'RANGER') $file = 'firstRanger-cape';
        elseif($user->rank == 'HEAD' && $user->type == 'MAESTER') $file = 'grandMaester-cape';
        elseif($user->type == 'RANGER') $file = 'ranger-cape';
        elseif($user->type == 'MAESTER') $file = 'maester-cape';
        elseif($user->type == 'BUILDER') $file = 'builder-cape';
        echo file_get_contents(Yii::app()->basePath."/data/{$file}.png");
    }

    public function actionView($unique)
    {
        $user = User::model()->with('socialProfile')->findByAttributes(array('ign' => $unique));
        if(!$user || $user->deserter == User::DESERTER_DISABLED || $user->deserter == User::DESERTER_ADMIN)
        {
            $this->layout = '//layouts/column1';
            $this->render('notAMember',array('name' => $unique));
            return;
        }
        if($user->deserter != User::DESERTER_NO)
        {
            if($user->deserter == User::DESERTER_LEFT) $verbbed = 'left';
            else $verbbed = 'deserted';
            throw new CHttpException(410,"{$user->ign} has {$verbbed} the Night's Watch.");
        }

        $this->setPageTitle($user->ign);

        Yii::app()->clientScript->registerLinkTag('shortcut icon','image/png',$user->headUrl(16));

        $this->layout = '//layouts/userColumn';

        $this->columnData['name'] = $user->ign;

        $this->menu[] = array(
            'label' => 'MineZ Profile',
            'url' => 'http://www.minez.net/?action=playersearch&player=' . urlencode($user->ign),
        );

        if($user->socialProfile && $user->socialProfile->reddit) $this->menu[] = array(
            'label' => 'Reddit Profile',
            'url' => 'http://www.reddit.com/user/' . urlencode($user->socialProfile->reddit),
        );

        if($user->socialProfile && $user->socialProfile->skype) $this->menu[] = array(
            'label' => 'Skype Profile',
            'url' => 'skype:' . urlencode($user->socialProfile->skype) . '?userinfo',
        );

        if($user->socialProfile && $user->socialProfile->twitter) $this->menu[] = array(
            'label' => 'Twitter Profile',
            'url' => 'http://twitter.com/' . urlencode($user->socialProfile->twitter),
        );

        $this->render('view',array(
            'user' => $user,
        ));
    }
}
