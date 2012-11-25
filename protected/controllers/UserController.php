<?php

class UserController extends Controller
{
    const LATEST_CAPE_VERSION = 1.7;

    public function filters()
    {
        return array(
            array(
                'IPLogFilter'
            ),
            array(
                'COutputCache + cape',
                'duration' => 60*5,
                'varyByParam' => array('unique','version','name','verify'),
                'cacheID' => 'filecache',
            ),
        );
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

    private function capeModIsUpToDate()
    {
        if(!isset($_REQUEST['version'])) return false;
        $explode = explode("_",$_REQUEST['version'],2);
        $ver = $explode[1];
        if($ver < self::LATEST_CAPE_VERSION) return false;
        return true;
    }

    private function capeBailOrUser($unique)
    {
        if(!$this->capeModIsUpToDate()) return null;
        $user = User::model()->findByAttributes(array('ign' => $unique));
        if(!$user) $kos = KOS::model()->findByAttributes(array('ign' => $unique));
        if(!$user && !$kos)
        {
            throw new CHttpException(404,"No Such User");
        }
        if(!$user->verified && !$kos)
        {
            throw new CHttpException(404,"User Not Verified");
        }
        if($user->deserter == User::DESERTER_LEFT && !$kos)
        {
            throw new CHttpException(404,"No Longer a Member");
        }
        if($user->deserter == User::DESERTER_DISABLED && !$kos)
        {
            throw new CHttpException(404,"Account Disabled");
        }
        if($user->deserter == User::DESERTER_ADMIN && !$kos)
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
        $this->capeBailOrUser($unique);
        header("HTTP/1.1 200 OK");
    }
    
    private function whiteList()
    {
        return Yii::app()->params['whitelist'];
    }
    
    private function verifyCanCape($name,$verify)
    {
    	$whiteList = $this->whiteList();
        if(md5(md5($name)."TheWatch") != $verify) return false;
        $user = User::model()->findByAttributes(array('ign' => $name,'verified' => 1,'deserter' => User::DESERTER_NO));
        if($user || in_array($name,$whiteList)) return true;
        return false;
    }

    public function actionCape($unique)
    {
        $whiteListed = in_array($_REQUEST['name'],$this->whiteList());
        Yii::app()->session->close();
        $this->filterOutStyleCodes($unique);
        $oldMod = !$this->capeModIsUpToDate();
        if(!$oldMod)
        {
            $user = $this->capeBailOrUser($unique);
            $kos = KOS::model()->findByAttributes(array('ign' => $unique));
            if($_REQUEST['version'] != 'TNW-viewer_1000' && !$this->verifyCanCape($_REQUEST['name'],$_REQUEST['verify'])) throw new CHttpException(503,"Bad Verification {$_REQUEST['name']}, {$_REQUEST['verify']}");
        }
        if(!$oldMod && !$user && !$kos) throw new CHttpException(404,"User does not exist");
        header("Content-Type: image/png");
        $file = "";
        if($oldMod) $file = 'nw-update';
        elseif($user && $user->deserter == 'DESERTER' && !$whiteListed) $file = 'deserter-cape';
        elseif($kos && $kos->status == KOS::STATUS_ACCEPTED && !$whiteListed) $file = 'kos-cape';
        elseif($user && $user->rank == User::RANK_COMMANDER) $file = 'commander-cape';
        elseif($user && $user->rank == User::RANK_HEAD && $user->type == User::TYPE_RANGER) $file = 'firstRanger-cape';
        elseif($user && $user->rank == User::RANK_HEAD && $user->type == User::TYPE_MAESTER) $file = 'grandMaester-cape';
        elseif($user && $user->rank == User::RANK_COUNCIL && $user->type == User::TYPE_RANGER) $file = 'rangerCouncil-cape';
        elseif($user && $user->rank == User::RANK_COUNCIL && $user->type == User::TYPE_MAESTER) $file = 'maesterCouncil-cape';
        elseif($user && $user->type == User::TYPE_RANGER) $file = 'ranger-cape';
        elseif($user && $user->type == User::TYPE_MAESTER) $file = 'maester-cape';
        elseif($user && $user->type == User::TYPE_BUILDER) $file = 'builder-cape';
        elseif($kos && $kos->status == KOS::STATUS_WARNING && !$whiteListed) $file = 'warning-cape';
        elseif($kos && $kos->status == KOS::STATUS_CAUTION && !$whiteListed) $file = 'wary-cape';
        
        $path = Yii::app()->basePath."/data/";
        if($user->deserter != 'DESERTER' && $user->honors > 0)
        {
            $max = 2;
            $stars = $user->honors > $max ? $max : $user->honors;
            $image = imagecreatefromstring(file_get_contents($path.$file.".png"));
            imagesavealpha($image,true);
            $overlay = imagecreatefromstring(file_get_contents($path."cape-star-{$stars}.png"));
            imagesavealpha($overlay,true);
            $w = imagesx($image);
            $h = imagesy($image);
            imagecopyresampled($image,$overlay,0,0,0,0,$w,$h,$w,$h);
            imagepng($image);
        }
        else echo file_get_contents($path.$file.".png");
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
