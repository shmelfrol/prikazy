<?php


namespace app\modules\logging\models;


use yii\db\ActiveRecord;

class LogEvent extends ActiveRecord
{

    public static function tableName()
    {
        return 'log_event';
    }



}