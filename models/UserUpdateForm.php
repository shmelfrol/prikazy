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
            ['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{2}\-[0-9]{3}\-[0-9]{2}$/', 'message' => 'Телефона, должно быть в формате +7(XXX)XX-XXX-XX'],
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