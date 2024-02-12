<?php


namespace app\models;


use yii\db\ActiveRecord;

class Ldap extends ActiveRecord
{
    public static function tableName()
    {
        return 'ldap';
    }
}