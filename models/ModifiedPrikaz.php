<?php


namespace app\models;

use app\components\EditinfoBehavior;
use yii\db\ActiveRecord;

class ModifiedPrikaz extends ActiveRecord
{



    public static function tableName()
    {
        return 'modified_prikazes';
    }


    public function behaviors()
    {
        return [
            EditinfoBehavior::className(),
        ];
    }






}