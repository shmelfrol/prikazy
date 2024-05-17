<?php


namespace app\models;


use yii\base\Model;

class PrikazDateForm extends Model
{
   public $year;
   public $month;
   public $text;

    public function rules()
    {
        return [
            [['year', 'month'], 'required'],
            [['text'], 'safe']
        ];
    }

    public function formName()
    {
        return '';
    }
}