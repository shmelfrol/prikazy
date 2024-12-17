<?php


namespace app\components;


use yii\base\Widget;

class PrikazStatusWidget extends Widget
{

    public $status_name;
    public $color;
    public $small;

    public function init()
    {
        parent::init();
        if ($this->small === null) {
            $this->small = false;
        }


    }


    public function run()
    {
        return $this->render('prikazStatus', ['color'=> $this->color, 'small'=>$this->small, 'status_name'=>$this->status_name]);
    }

}