<?php


function addLog($user, $event, $text){
    $log = new \app\modules\logging\models\Log();
    $log->user_id = $user->id;
    $e = \app\modules\logging\models\LogEvent::findOne(['name' => $event]);
    $log->event_id = $e->id;
    $log->date = time();
    $log->text = $event ."". $text . ' пользователем - ' . $user->identity->username;
    $log->save();
}

