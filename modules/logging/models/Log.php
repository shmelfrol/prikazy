<?php

namespace app\modules\logging\models;


use app\models\User;

class Log extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log';
    }


    public function getEvent(){
        return $this->hasOne(LogEvent::className(), ['id' => 'event_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}