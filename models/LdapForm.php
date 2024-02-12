<?php


namespace app\models;


use yii\base\Model;

class LdapForm extends Model
{
    public $account_suffix;
    public $hosts;
    public $base_dn;
    public $username;
    public $password;
    public $turnon;

      public function rules()
      {
          return [
              [['account_suffix', 'hosts', 'base_dn', 'username' , 'password', 'turnon'], 'required'],
          ];
      }
}

