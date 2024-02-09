<?php

use app\models\User;


function CreateUser($username, $password){
    $newUser = new User();
    $newUser->username = $username;
    $newUser->password = Yii::$app->security->generatePasswordHash($password);
    $time=time();
    $newUser->created_at=$time;
    $newUser->updated_at=$time;
    $newUser->authKey=Yii::$app->security->generateRandomString();

}
