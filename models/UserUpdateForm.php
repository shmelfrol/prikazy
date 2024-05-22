<?php


namespace app\models;
require_once '../helpers/user.php';

use Yii;


class UserUpdateForm extends \yii\base\Model
{
    public $id;
    public $username;
    public $password;
    public $repassword;
    public $roles;
    public $phone;

    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required'],
            ['roles', 'checkIsArray'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            CreateUser($this->username, $this->password);
        }
    }

    public function checkIsArray()
    {

    }

    public function validatePassword()
    {

    }

    public function validatePhone()
    {

    }

}