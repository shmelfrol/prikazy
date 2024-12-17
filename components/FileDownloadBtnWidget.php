<?php


namespace app\components;


use yii\base\Widget;

class FileDownloadBtnWidget extends Widget
{

    public $file;
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
        return $this->render('fileDownloadBtn', ['file'=>$this->file, 'trashIcon'=>$this->trashIcon]);
    }

}