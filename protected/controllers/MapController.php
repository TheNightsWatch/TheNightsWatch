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
        $out = array();
        foreach($locs as $loc)
        {
            $out[] = array(
                'timestamp' => $loc->lastUpdate->format('Ymd H:i:s'),
                'id' => 4,
                'msg' => $loc->user->ign,
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
            header("HTTP/1.1 401");
            Yii::app()->end();
        }
        $user = User::model()->findByAttributes(array('ign' => $name));
        if(!$user)
        {
            header("HTTP/1.1 404");
            Yii::app()->end();
        }
        if(!$user->location)
        {
            $loc = new UserLocation;
            $loc->userID = $user->id;
        } else $loc = $user->location;
        $loc->updateLocation($x,$y,$z,$server);
        header("HTTP/1.1 201");
        Yii::app()->end();
    }

    public function actionDownload($path)
    {
        Yii::app()->session->close();
        // This should only be called for 404s.  It downloads the corresponding image from MineZ
        // and then adds it to our file structure.
        $ourFiles = Yii::app()->basePath . '/../external/map/MineZ/';
        $pathArray = explode("/",$path);
        $file = array_pop($pathArray);
        $url = "http://minez.net/map/MineZ/{$path}";

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 1,
                'user_agent' => "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2) Gecko/20100301 Ubuntu/9.10 (karmic) Firefox/3.6",
                'header' => array(
                    'Accept' => 'image/png;q=0.9,*/*;q=0.8'
                ),
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