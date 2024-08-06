<?php


namespace app\components;


use yii\base\Widget;

class DivisionWidget extends Widget
{
    public $name;
    public $color;
    public $small;
    public $hidden;


    public function init()
    {
        parent::init();
        if ($this->small === null) {
            $this->small = false;
        }
        if($this->hidden === null){
            $this->hidden= false;
        }

    }



    public function run()
    {
        return $this->render('division', [
            'name'=>$this->name,
            'color'=>$this->color,
            'small'=>$this->small,
            'hidden'=>$this->hidden

        ]);
    }


}