<?php


namespace app\components;


use yii\base\Widget;

class PageTitle extends Widget
{

    public $title;
    public $url;

    public function run()
    {
        return $this->render('title', ['url'=> $this->url, 'title'=>$this->title]);
    }

}