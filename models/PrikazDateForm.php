<?php


namespace app\models;


use yii\base\Model;

class PrikazDateForm extends Model
{
   public $year;
   public $month;

    public function rules()
    {
        return [
            [['year', 'month'], 'required'],
        ];
    }

    public function formName()
    {
        return '';
    }
}