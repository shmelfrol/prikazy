<?php


namespace app\components;


use yii\base\Widget;

class InputFileWidget extends Widget
{

    public $model;
    public $hidden;
    public $form;


    public function run()
    {
        return $this->render('inputFileWidget', ['model'=> $this->model, 'hidden'=>$this->hidden, 'form'=>$this->form]);
    }

}