<?php


namespace app\components;


use yii\base\Widget;

class CardWidget extends Widget
{

    public $name;
    public $isold;
    public $description;
    public $created_at;
    public $del_url;
    public $update_url;
    public $id;
    public $color;



    public function run()
    {
        return $this->render('card', [
            'name'=> $this->name,
            'isold'=>$this->isold,
            'description'=>$this->description,
            'created_at' => $this->created_at,
            'del_url'=>$this->del_url,
            'update_url'=>$this->update_url,
            'id'=>$this->id,
            'color'=>$this->color
        ]);
    }

}