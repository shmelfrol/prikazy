<?php


namespace app\components;


use yii\base\Widget;

class ModifiedPrikazListWidget extends Widget
{

    public $p;
    public $indexes;
    public $canceled;
    public $modified;
    public $canceling;
    public $modifing;
    public $update;

    public function init()
    {
        parent::init();
        if ($this->update === null) {
            $this->update = false;
        }
    }







    public function run()
    {
        return $this->render('modifiedPrikazList',[
            'p'=>$this->p,
            'indexes'=>$this->indexes,
            'canceled'=>$this->canceled,
            'modified'=>$this->modified,
            'canceling'=>$this->canceling,
            'modifing'=>$this->modifing,
            'update'=>$this->update,
        ] );
    }


}