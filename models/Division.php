<?php


namespace app\models;


use yii\db\ActiveRecord;

class Division extends ActiveRecord
{
    public static function tableName()
    {
        return 'division';
    }


    public function rules()
    {
        return [
            [['name', 'short_name', 'color'], 'required'],
            [[ 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
        ];
    }




}