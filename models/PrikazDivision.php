<?php


namespace app\models;


use yii\db\ActiveRecord;

class PrikazDivision extends ActiveRecord
{
    public static function tableName()
    {
        return 'prikaz_division';
    }


    public function rules()
    {
        return [
            [[ 'prikaz_id', 'division_id', 'id'], 'safe'],
        ];
    }




}