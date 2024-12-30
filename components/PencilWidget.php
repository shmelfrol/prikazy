<?php


namespace app\components;


use yii\base\Widget;

class PencilWidget extends Widget
{
    public $url;
    public $params;





    public function run()
    {
        return $this->render('pencil', ['url'=>$this->url, 'params'=>$this->params]);
    }


}