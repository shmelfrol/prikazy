<?php


namespace app\models;

use app\components\EditinfoBehavior;
use yii\db\ActiveRecord;

class ActionType extends ActiveRecord
{



    public static function tableName()
    {
        return 'prikaz_action_type';
    }

    //
    public function behaviors()
    {
        return [
            EditinfoBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['id','status_name', 'color'], 'safe'],
        ];
    }







}