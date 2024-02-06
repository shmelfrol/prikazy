<?php


namespace app\models;


class UpdatePermissionForm extends \yii\base\Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'description'], 'required'],

        ];
    }

}