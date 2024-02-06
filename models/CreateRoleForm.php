<?php


namespace app\models;


class CreateRoleForm extends \yii\base\Model
{
    public $name;
    public $description;


    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
        ];
    }
}