<?php


namespace app\models;
use yii\db\ActiveRecord;

class Favorite extends ActiveRecord
{
 public $symbol;


    public static function tableName()
    {
        return 'favorite';
    }


    public function rules()
    {
        return [
            [['id', 'prikaz_id', 'user_id'], 'safe'],
        ];
    }



    public function getPrikaz(){
        return $this->hasOne(Prikaz::className(), ['id' => 'prikaz_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}