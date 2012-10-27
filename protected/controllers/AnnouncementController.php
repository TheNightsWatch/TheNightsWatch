<?php

class AnnouncementController extends Controller
{
    public function filters()
    {
        return array(
            array(
                'CouncilFilter - view',
            ),
            array(
                'BanFilter',
            ),
            array(
                'VerifyFilter - view',
            ),
            array(
                'IPLogFilter'
            ),
        );
    }
    public function actionView($id)
    {
        $announcement = Announcement::model()->findByPk($id);
        $user = !Yii::app()->user->isGuest ? User::model()->findByPk(Yii::app()->user->getId()) : false;
        if(!$announcement)
            throw new CHttpException(404,"No Such Announcement");

        if((Yii::app()->user->isGuest || !$user->verified || $user->deserter != User::DESERTER_NO) && ($announcement->go_public == NULL || $announcement->go_public->getTimestamp() > time()))
            throw new CHttpException(403,"Access Denied");

        $this->render('view',array('model' => $announcement));
    }

    public function actionCreate()
    {
        $announcement = new Announcement;
        if(isset($_POST['Announcement'])) $announcement->attributes = $_POST['Announcement'];
        $this->render('create',array('model' => $announcement));
    }

    public function actionPreview()
    {
        $announcement = new Announcement;
        $announcement->attributes = $_POST['Announcement'];
        $announcement->timestamp = 'now';
        $this->_modifyAnnouncement($announcement);

        $this->render('preview',array('model' => $announcement));
    }

    public function actionPost()
    {
	Yii::app()->session->close();
        $announcement = new Announcement;
        $announcement->attributes = $_POST['Announcement'];
        $announcement->userID = Yii::app()->user->getId();

        $sender = User::model()->findByPk(Yii::app()->user->getId());
        $users = User::model()->with('settings')->findAllByAttributes(array('deserter' => 'NO','verified' => 1));
        $bcc = array();
        foreach($users as $user)
        {
            if((!$user->settings || $user->settings->email) && !empty($user->email))
                $bcc[] = $user->email;
        }

        if($announcement->save())
        {
            $message = new YiiMailMessage;
            $message->setSubject($announcement->subject);
            $message->setFrom(array($sender->ign.'@minez-nightswatch.com' => $sender->title . ' ' . $sender->ign));
            $message->setTo(array('members@minez-nightswatch.com' => "The Night's Watch"));
            $message->setBcc($bcc);
            $body = $announcement->body . '<br /><hr /><center>You can unsubscribe from these emails at any time by accessing the <a href="'.$this->createAbsoluteUrl('site/profile').'">the profile page</a>.</center>';
            $message->setBody($body,'text/html','UTF-8');
            $amt = Yii::app()->mail->send($message);
            die('The Announcement has been saved and sent to '.$amt.' people');
        }
    }

    /**
     * Adds the necessary stylistic changes
     * @param Announcement $model
     */
    private function _modifyAnnouncement(&$model)
    {
        $body = $model->body;
        if(substr($body,0,4) !== '<div') $body = '<div style="color:#222;width:400px;font-family:Georgia, serif;text-align:justify;line-height:14pt;font-size:12pt;">' . "\n" . $body . "\n" . '</div>';

        $body = str_replace('<p>','<p style="text-indent:1em;">',$body);
        $body = str_replace(array('<blockquote>','</blockquote>'),array('<p style="padding-left:1em;">','</p>'),$body);

        $model->body = $body;
    }
}
