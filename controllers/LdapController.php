<?php


namespace app\controllers;


use yii\web\Controller;
use Yii;
class LdapController extends Controller
{
 public function actionIndex(){
     $un='test_user';
     $ldapObject = \Yii::$app->ad->search()->findBy('sAMAccountname', $un);
     Yii::$app->ad->
     $group=$ldapObject->memberof;
     return print_r($group);
 }


}