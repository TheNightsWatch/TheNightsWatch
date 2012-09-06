<?php

class ChatController extends Controller
{
    public $chatUsers = array();
    public $announcement;

    public function filters()
    {
        return array(
            'accessControl',
            array(
                'BanFilter',
            ),
            array(
                'VerifyFilter',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index','view','new','post','ping'),
                'users' => array('@'),
            ),
            array('deny',
                'actions'=>array('index','view','new','post','ping'),
                'users'=>array('*')
            ),
        );
    }

    public function actionIndex()
    {
        // Until we actually make a multi-room system.
        $this->actionView('lobby');
    }

    public function actionView($room = 'lobby')
    {
        $this->layout = '//layouts/chatColumn';
        $data = ChatMessage::model()->with('user')->findAllByAttributes(array('room' => $room),array(
            'limit' => 20,
            'order' => 'timestamp DESC',
        ));

        $messages = array();
        foreach($data as $datum)
        {
            array_unshift($messages,$datum);
        }

        $this->chatUsers = User::model()->with(array(
            'chatViews' => array(
                'joinType'=>'INNER JOIN',
                'order' => 'rank DESC',
                'condition'=>'chatViews.room = :room AND timestamp > FROM_UNIXTIME(UNIX_TIMESTAMP()-60)',
                'params' => array('room' => $room),
            ),
        ))->findAll();

        $announcement = Announcement::model()->find(array(
            'order' => 'id DESC',
        ));


        if($announcement->expires == NULL || $announcement->expires->getTimestamp() > time())
            $this->announcement = $announcement;

        $this->render('index',array(
            'messages' => $messages,
        ));
    }

    public function actionNew($since,$room = 'lobby')
    {
        Yii::app()->session->close();
        $view = ChatView::model()->findByAttributes(array(
            'room' => $room,
            'userID' => Yii::app()->user->getId(),
        ));
        if(!$view)
        {
            $view = new ChatView;
            $view->room = $room;
            $view->userID = Yii::app()->user->getId();
        }
        $view->timestamp = time();
        $view->save();

        $messages = ChatMessage::model()->with('user')->findAllByAttributes(array('room' => $room),'t.id > :since',array('since' => $since));
        $output = array();
        foreach($messages as $message)
        {
            $output[] = array(
                'id' => $message->id,
                'text' => $message->message,
                'html' => TextParser::parse(htmlspecialchars($message->message)),
                'timestamp' => $message->timestamp->getTimestamp(),
                'user' => array(
                    'id' => $message->user->id,
                    'ign' => $message->user->ign,
                    'type' => $message->user->type,
                    'rank' => $message->user->rank,
                    'title' => $message->user->title,
                    'img' => $message->user->headUrl(64),
                    'url' => $this->createUrl('user/view',array('unique' => $message->user->ign)),
                ),
            );
        }

        $users = User::model()->with(array(
            'chatViews' => array(
                'joinType'=>'INNER JOIN',
                'order' => 'rank DESC',
                'condition'=>'chatViews.room = :room AND timestamp > FROM_UNIXTIME(UNIX_TIMESTAMP()-60*5)',
                'params' => array('room' => $room),
            ),
        ))->findAll();
        $uout = array();
        foreach($users as $user)
        {
            $uout[] = array(
                'id' => $user->id,
                'ign' => $user->ign,
                'type' => $user->type,
                'title' => $user->title,
                'rank' => $user->rank,
                'img' => $user->headUrl(16),
                'url' => $this->createUrl('user/view',array('unique' => $user->ign)),
            );
        }
        $this->jsonOut(array('users' => $uout, 'messages' => $output, 'csrf' => array('name' => Yii::app()->request->csrfTokenName, 'token' => Yii::app()->request->csrfToken)));
    }

    public function actionPing($room = 'lobby')
    {
        Yii::app()->session->close();
        $this->jsonOut('Not Supported',501);
    }

    public function actionPost($room = 'lobby')
    {
        Yii::app()->session->close();
        $model = new ChatForm;
        if(isset($_POST['ChatForm']))
        {
            $model->attributes=$_POST['ChatForm'];
            if($model->validate())
            {
                $old = ChatMessage::findByAttributes(array(
                    'condition' => 'userID = :id AND room = :room',
                    'params' => array('id' => Yii::app()->user->getId(),'room' => $room),
                    'order' => 'timestamp DESC',
                ));
                if($old->message != $new->message)
                {
                    $message = new ChatMessage;
                    $message->userID = Yii::app()->user->getId();
                    $message->message = $model->message;
                    $message->room = $room;
                    $success = $message->save();
                } else $success = true;
                if(Yii::app()->request->isAjaxRequest) $this->jsonOut(array(
                    'success' => $success,
                    'message' => $success ? $message : null,
                    'csrf' => array(
                        'name' => Yii::app()->request->csrfTokenName,
                        'value' => Yii::app()->request->csrfToken,
                    ),
                ),200,true);
            }
        }
        $this->redirect(array('chat/index'));
    }
}