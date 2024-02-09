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
    $newUser->save();
    return $newUser;
}

function ResetUserPas($user, $password){
    $user->password = Yii::$app->security->generatePasswordHash($password);
    $user->updated_at=time();
    $user->save();
    return $user;
}