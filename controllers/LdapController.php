<?php


namespace app\controllers;


use app\models\LdapLoginForm;
use yii\web\Controller;
use Yii;
class LdapController extends Controller
{
 public function actionIndex(){
     $un='test_user';
     $ldapObject = \Yii::$app->ad->search()->findBy('sAMAccountname', $un);

     $group=$ldapObject->memberof;
     $model = new LdapLoginForm();

     if ($model->load(Yii::$app->request->post()) && $model->validate()) {


         if(Yii::$app->ad->auth()->attempt($model->username,$model->password)){
             return "OK";
         }else{return "dhdtjtyj";}
    }

     return $this->render('loginForm', compact('model',));
 }


}