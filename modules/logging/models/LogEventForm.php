<?php


namespace app\modules\logging\models;


use yii\base\Model;

class LogEventForm extends Model
{

    public $name;

    public function rules()
    {
        return [
          [['name'], 'required']
        ];
    }
}