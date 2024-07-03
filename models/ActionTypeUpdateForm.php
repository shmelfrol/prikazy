<?php


namespace app\models;
require_once '../helpers/user.php';




class ActionTypeUpdateForm extends \yii\base\Model
{
    public $status_name;
    public $color;


    public function rules()
    {
        return [
            [['status_name', 'color'], 'required'],

        ];
    }



}