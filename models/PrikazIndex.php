<?php


namespace app\models;


use yii\db\ActiveRecord;

class PrikazIndex extends ActiveRecord
{
    public $prikaz_index;
    public $description;
    public $isold;
    public $created_at;
    public $updated_at;

    public static function tableName()
    {
        return 'prikazindex';
    }

    public function rules()
    {
        return [
            ['numc', 'integer', 'pattern' => '/d+/m', 'message' => 'Здесь допустимы только цифры' ],
            ['right', 'string', 'pattern' => '/[\?\!]+/m', 'message' => 'Здесь допустимы латинские буквы' ],
        ];
    }


}