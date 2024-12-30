<?php


namespace app\components;


use yii\base\Widget;

class FavIconWidget extends Widget
{
public $p;



    public function run()
    {
        return $this->render('fav', ['p'=>$this->p]);
    }

}