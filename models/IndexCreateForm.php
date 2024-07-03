<?php


namespace app\models;
use yii\db\ActiveRecord;
use function Codeception\Lib\Console\message;

class IndexCreateForm extends \yii\base\Model
{
    public $symbol;
    public $description;
    public $isold;




    public function rules()
    {
        return [
            [['description'], 'required'],
            ['symbol', 'match', 'pattern' => '/^[А-Я]+$/m', 'message' => 'Допустимы только сочетания прописных русских букв: А-Я!!!' ],
            ['isold', 'boolean'],

        ];
    }




}