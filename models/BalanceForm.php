<?php


namespace app\models;
use yii\base\Model;

class BalanceForm extends Model
{
  public $left;
  public $right;


    public function rules()
    {
        return [



            ['left', 'match', 'pattern' => '/[\?\!]+/m', 'message' => 'Здесь допустимы только знаки: ? и !' ],
            ['right', 'match', 'pattern' => '/[\?\!]+/m', 'message' => 'Здесь допустимы только знаки: ? и !' ],
        ];
    }


}