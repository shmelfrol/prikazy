<?php


namespace app\components;


use yii\base\Widget;

class PrikazTitle extends Widget
{

    public $p;


    public function run()
    {
        return $this->render('prikazTitle', ['p'=> $this->p]);
    }

}