<?php


namespace app\models;


class UpdateRoleForm extends \yii\base\Model
{
    public $name;
    public $permissions;
    public $description;
    public $roles;

    public function rules()
    {
        return [
            // username and password are both required
            [['name'], 'required'],

        ];
    }
}