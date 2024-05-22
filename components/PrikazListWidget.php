<?php


namespace app\components;


use yii\base\Widget;

class PrikazListWidget extends Widget
{

    public $prikazes;
    public $btndel;
    public $btnedit;



    public function run()
    {
        return $this->render('prikazList', ['prikazes'=> $this->prikazes, 'btndel'=>$this->btndel, 'btnedit'=> $this->btnedit]);
    }


}