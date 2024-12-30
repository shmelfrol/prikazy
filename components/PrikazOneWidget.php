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

    public $divisions;

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
        if($this->p->divisions){
            if($this->divisions=== null){
                if($this->p->divisions){
                    $strings= explode(",",$this->p->divisions);
                    $this->divisions=array_map([$this, 'divToArr'], $strings);
                }
            }
        }else {
            $this->divisions=[];
        }

    }

    public function divToArr($str){
        $division=[];
        $name= substr($str, 0,strpos($str, '#') );
        $color=substr($str, strpos($str, '#')  );
        $division['color']=$color;
        $division["name"]=$name;
        return $division;
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
            'action_id'=>$this->action_id,
            'divisions'=>$this->divisions
        ]);
    }


}