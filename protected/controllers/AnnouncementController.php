<?php

class AnnouncementController extends Controller
{
    public function actionView($id)
    {
        $announcement = Announcement::model()->findByPk($id);
        if(!$announcement)
            throw new CHttpException(404,"No Such Announcement");

        if(Yii::app()->user->isGuest && ($announcement->go_public == NULL || $announcement->go_public->getTimestamp() < time()))
            throw new CHttpException(403,"Access Denied");
        
        $this->render('view',array('model' => $announcement));
    }
}