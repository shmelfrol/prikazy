<?php

namespace app\modules\logging\controllers;


use app\modules\logging\models\Log;
use app\modules\logging\models\LogEvent;
use app\modules\logging\models\LogEventForm;
use Yii;

use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminUrl
{
    public $url;
    public $name;
    public $img;
}

/**
 * Default controller for the `logging` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $events = new AdminUrl();
        $events->url = 'events';
        $events->name = "Типы событий";
        $events->img = '/images/users.png';

        $logs = new AdminUrl();
        $logs->url = 'logs';
        $logs->name = "Логи";
        $logs->img = '/images/users.png';

        $urls = [$logs, $events];

        return $this->render('index', ['urls'=>$urls]);
    }


    public function actionEvents(){
        $events= LogEvent::find()->all();
        return $this->render('events', ['events'=>$events]);

    }


    public function actionAddEvent(){

        $model= new LogEventForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            if (!$model->validate()) {
                var_dump($model->getErrors());
                die();
            }

            $e= new LogEvent();
            $e->name=$model->name;
            $e->save();
            return $this->redirect('/logging/default/events');
        }



        return $this->render('add-event', ['model'=>$model]);

    }

    public function actionLogs(){
        //$logs=Log::find()->orderBy(['id' => SORT_DESC])->all();
        $query = Log::find()->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 15,
            ]);
        $logs = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        return $this->render('logs', ['logs'=>$logs, 'pages'=>$pages]);


    }

}
