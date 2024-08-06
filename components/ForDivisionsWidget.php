<?php


namespace app\components;


use yii\base\Widget;

class ForDivisionsWidget extends Widget
{
    public $divisions;
    public $checked_ids;
    public $plus;


    public function init()
    {
        parent::init();
        if ($this->plus === null) {
            $this->plus = false;
        }


    }



    public function run()
    {
        return $this->render('forDivisions', [
            'divisions'=>$this->divisions,
            'checked_ids'=>$this->checked_ids,
            'plus'=>$this->plus

        ]);
    }


}