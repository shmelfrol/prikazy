<?php


namespace app\components;


use yii\base\Widget;

class TrashIconWidget extends Widget
{




    public function run()
    {
        return $this->render('trash');
    }

}