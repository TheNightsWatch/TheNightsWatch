<?php 

class MapController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            array(
                'BanFilter + view, players',
            ),
            array(
                'VerifyFilter + view, players',
            ),
            array(
                'IPLogFilter'
            ),
        );
    }

    public function getActionParams()
    {
        return $_REQUEST;
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('view','download','places','players'),
                'users' => array('@'),
            ),
            array('deny',
                'actions'=>array('view','download','places','players'),
                'users'=>array('*')
            ),
        );
    }
    public function actionView()
    {
        $this->layout = '//layouts/blank';
        $this->render('index');
    }
    public function actionPlaces()
    {
        $this->jsonOut(Place::model()->findAll());
    }

    public function actionPlayers()
    {
        Yii::app()->session->close();
        $locs = UserLocation::model()->with('user')->findAll('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(lastUpdate) < 60');
        $loggedInUser = User::model()->findByPk(Yii::app()->user->getId());
        $out = array();
        foreach($locs as $loc)
        {
            if( // Display this user under any of these circumstances
                true || // Enable Live Map for all again
                $loc->user->id == $loggedInUser->id || // The user to be displayed is the logged in user 
                $loggedInUser->deserter == User::DESERTER_ADMIN || // The logged in user is an "Admin"
                in_array($loggedInUser->rank,array(User::RANK_HEAD,User::RANK_COMMANDER,User::RANK_COUNCIL)) || // The logged in user is Council or Above
                $loc->user->deserter == User::DESERTER_DESERTER // The user is a deserter
            )
                $out[] = array(
                    'timestamp' => $loc->lastUpdate->format('Ymd H:i:s'),
                    'id' => 4,
                    'msg' => $loc->user->ign,
                    'display' => ($loc->user->deserter == User::DESERTER_DESERTER ? '<abbr title="Deserter">[D]</abbr> ' : '').$loc->user->ign,
                    'x' => $loc->x,
                    'y' => $loc->y,
                    'z' => $loc->z,
                    'world' => 'MineZ - overworld',
                    'server' => $loc->server,
                    'rank' => $loc->user->rank,
                );
        }
        $this->jsonOut($out);
    }

    public function actionPoints()
    {
        header("Content-Type: text/plain");
        $places = Place::model()->findAll(array('order' => 'name ASC'));
        foreach($places as $place)
        {
            $hex = dechex($place->color);
            if(strlen($hex) < 6)
            {
                $hex = str_repeat("0",6 - strlen($hex)) . $hex;
            }
            $hex = strtoupper($hex);
            $on = 'false';
            if($place->type == 'TOWN') $on = 'true';
            echo $place->name,":",$place->x,":",$place->y,":",$place->z,":{$on}:",$hex,"\n";
        }
    }

    public function actionUpdate($name,$verify,$x,$y,$z,$server)
    {
        Yii::app()->session->close();
        if($verify != md5(md5($name)."TheWatch"))
        {
            throw new CHttpException(401,"Wrong Verification");
        }
        $user = User::model()->findByAttributes(array('ign' => $name));
        if(!$user)
        {
            throw new CHttpException(404,"User not Found");
        }
        if(!$user->location)
        {
            $loc = new UserLocation;
            $loc->userID = $user->id;
        } else $loc = $user->location;
        $loc->updateLocation($x,$y,$z,$server);
        if(strpos(".",$server) === false) $server = $server.'.minez.net';
        // Look for Events
        $ip = gethostbyname($server);
        $events = Event::model()->findAll(array(
            'condition' => '(ip LIKE :ip OR ip IS NULL) AND (:x BETWEEN x1 AND x2 OR :x BETWEEN x2 AND x1) AND (:y BETWEEN y1 AND y2 OR :y BETWEEN y2 AND y1) AND (NOW() BETWEEN start AND end OR (NOW() > start AND end IS NULL))',
            'params' => array('x' => $x, 'y' => $z, 'ip' => $ip),
        ));
        foreach($events as $event)
        {
            $event->addAttendee($user);
        }

        header("HTTP/1.1 201");
        Yii::app()->end();
    }

    public function actionDownload($path)
    {
        Yii::app()->session->close();
        // This should only be called for 404s.  It downloads the corresponding image from MineZ
        // and then adds it to our file structure.
        $ourFiles = Yii::app()->basePath . '/../map/MineZ/';
        $pathArray = explode("/",$path);
        $file = array_pop($pathArray);
        $url = "http://www.hcfactions.net/minez/map/MineZ/{$path}";
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 2,
                'protocol_version' => 1.1,

            ),
        ));
        $contents = @file_get_contents($url,false,$context);
        if($contents)
        {
            if(!file_exists($ourFiles . implode("/",$pathArray)))
                mkdir($ourFiles . implode("/",$pathArray),0775,true);

            file_put_contents($ourFiles . implode("/",$pathArray) . "/" . $file,$contents);
            $this->refresh(true);
        } else {
            $this->redirect($url,true,302);
        }
    }
}
