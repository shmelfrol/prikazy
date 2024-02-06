<?php


namespace app\controllers;

use Yii;
use app\models\BalanceForm;
use yii\web\Controller;

class BalanceController extends Controller
{

    public function actionIndex()
    {
        $model = new BalanceForm();
        $left=0;
        $right=0;
        $balance=0;
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if($post['BalanceForm']['left']){
                $arr = str_split($post['BalanceForm']['left']);
               foreach ($arr as $k=>$v){
                   if($v === '?'){
                       $left=$left+3;
                   }
                   if($v === '!'){
                       $left=$left+2;
                   }
               }
            }
            if($post['BalanceForm']['right']){
                $arr = str_split($post['BalanceForm']['right']);
                foreach ($arr as $k=>$v){
                    if($v === '?'){
                        $right=$right+3;
                    }
                    if($v === '!'){
                        $right=$right+2;
                    }
                }
            }

            if($right >$left){
                return 'right';
            }
            if($left>$right){
                return 'left';
            }
            if($left===$right){
                return 'BALANCE';
            }
            return "left:".$left." right:".$right."__";

        }
        return $this->render('index', compact('model'));
    }


}