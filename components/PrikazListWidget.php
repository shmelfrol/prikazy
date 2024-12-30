<?php


namespace app\components;


use yii\base\Widget;

class PrikazListWidget extends Widget
{

    public $prikazes;
    public $btndel;
    public $btnedit;
    public $btncancel;
    public $heart;
    public $action_id;


    public function run()
    {
        return $this->render('prikazList', ['prikazes'=> $this->prikazes, 'btndel'=>$this->btndel, 'btnedit'=> $this->btnedit, 'btncancel'=>$this->btncancel, 'heart'=>$this->heart, 'action_id'=>$this->action_id]);
    }


}