<?php


namespace app\components;


use yii\base\Widget;

class FileIframePDFWidget extends Widget
{

    public $prikaz_id;
    public $trashIcon;

    public function init()
    {
        parent::init();
        if ($this->trashIcon === null) {
            $this->trashIcon = false;
        }
    }


    public function run()
    {
        return $this->render('fileIframePDF', ['prikaz_id'=>$this->prikaz_id, 'trashIcon'=>$this->trashIcon]);
    }

}