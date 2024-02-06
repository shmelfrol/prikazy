<?php


namespace app\models;


class UserCreateForm extends \yii\base\Model
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
            // rememberMe must be a boolean value

            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{2}\-[0-9]{3}\-[0-9]{2}$/', 'message' => 'Телефона, должно быть в формате +7(XXX)XX-XXX-XX' ],
        ];
    }


    public function validatePassword(){

    }
    public function validatePhone(){

    }

}