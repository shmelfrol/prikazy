<?php

namespace app\components;


use Yii;

class BackButtonWidget extends \yii\base\Widget
{

    public $url;

    public function init()
    {
        parent::init();
        if ($this->url === null) {
            $this->url = Yii::$app->request->referrer;;
        }
    }

    public function run()
    {
       return $this->render('backbutton', ['url'=> $this->url]);
    }
}