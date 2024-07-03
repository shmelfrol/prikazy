<?php


namespace app\models;
use yii\db\ActiveRecord;
use function Codeception\Lib\Console\message;

class PrikazCreateForm extends \yii\base\Model
{
    public $numc;
    public $index_id;
    public $reldate;
    public $text;
    public $file;

    public function rules()
    {
        return [
            [['numc', 'index_id'], 'integer', 'message'=> "Разрешены только цифры"],
            [['text'], 'required', 'message' => 'Текст не более 150 символов'],
            ['reldate', 'date', 'format' => 'dd-mm-yyyy'],
            [['file'], 'file', 'extensions'=> 'pdf', 'mimeTypes'=>['application/pdf'] ]
        ];
    }

}