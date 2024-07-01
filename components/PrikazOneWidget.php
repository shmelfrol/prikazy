<?php


namespace app\components;


use yii\base\Widget;

class PrikazOneWidget extends Widget
{

    public $p;
    public $hidden;
    public $btndel;
    public $btnedit;
    public $btncancel;
    public $heart;
    public $action_id;

    public function init()
    {
        parent::init();
        if ($this->hidden === null) {
            $this->hidden = false;
        }
        if($this->heart === null){
            $this->heart= true;
        }
        if($this->btncancel === null){
            $this->btncancel= false;
        }
    }




    public function run()
    {
        return $this->render('prikazOne', [
            'p'=> $this->p,
            "hidden"=>$this->hidden,
            'btndel'=>$this->btndel,
            'btnedit'=> $this->btnedit,
            'heart'=>$this->heart,
            'btncancel'=>$this->btncancel,
            'action_id'=>$this->action_id
        ]);
    }


}