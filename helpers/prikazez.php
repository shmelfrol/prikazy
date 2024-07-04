<?php

use app\models\Favorite;
use app\models\Prikaz;
use yii\helpers\FileHelper;


require_once dirname(__DIR__) . '/modules/logging/helpers/logs.php';

define('STATUS_P_MODIFIED', 'изменен');
define('STATUS_P_CANCELED', 'отменен');
define('STATUS_P_ENABLED', 'действующий');

function GetPrikazName($numc, $nums, $reldate, $fileExt)
{
    $timestamp = strtotime($reldate);
    $y = date('Y', $timestamp);
    $m = date('m', $timestamp);
    $d = date('d', $timestamp);
    $index = RuStringToEng($nums);
    // $dir = '/prikazes/';
    $fullFilePath = '/' . $y . '/' . $y . $m . $d . '-' . 'N' . $numc . "-" . $index . "." . $fileExt;
    return $fullFilePath;
}


function CreatePrikazFolder($reldate)
{
    $timestamp = $reldate;
    $y = date('Y', $timestamp);
    $dir = dirname(__DIR__) . '/prikazes/';
    // Если нет папки с годом создаем ее
    if (!is_dir($dir . '/' . $y)) {
        try {
            FileHelper::createDirectory($dir . '/' . $y);
        } catch (\yii\base\Exception $e) {
            throw $e;
        }
    }

}

function getPrikaz($id){
    $user_id = Yii::$app->user->identity->getId();
    $subQFav=Favorite::find()->where(['user_id'=>$user_id]);
    return Prikaz::find()
        ->select([
            'prikaz.*',
            'fav.prikaz_id',
            "COALESCE(pi.symbol, '') as symbol",
            "COALESCE(status.status_name, '') as status_name",
            "COALESCE(status.color, '') as color",
        ])
        ->leftJoin(['pi' => "prikazindex"], 'pi.id=prikaz.index_id')
        ->leftJoin(['fav' => $subQFav], 'fav.prikaz_id=prikaz.id')
        ->leftJoin(['status' => "prikaz_action_type"], 'status.id=prikaz.action_id')
        ->where(['is_del'=>false])
        ->where(['prikaz.id'=>$id])
        ->orderBy('id')
        ->one();
}


function CreatePrikaz($index_id, $fullFilePath, $numc, $reldate, $text, $oldfilename = "-")
{
    if (!$numc) {
        $numc = null;
    }
    $oldPrikaz = Prikaz::find()->where(["index_id" => $index_id, "numc" => $numc, "reldate" => strtotime($reldate), "oldfilename" => $oldfilename, 'is_del' => false])->all();

    if (empty($oldPrikaz)) {
        $prikaz = new Prikaz();
        $prikaz->index_id = $index_id;
        $prikaz->filename = $fullFilePath;
        $prikaz->numc = $numc;
        $prikaz->reldate = strtotime($reldate);
        $prikaz->text = $text;
        $prikaz->oldfilename = $oldfilename;
        $prikaz->created_at = time();
        $prikaz->is_del = false;
        $prikaz->action_id = '3';
        $currentUser = Yii::$app->user;
        $prikaz->created_by = $currentUser->id;
        if ($prikaz->save()) {

            addLog($currentUser, 'создание', $fullFilePath);

        };
        return $prikaz;
    }

}


function RuStringToEng($str)
{
    $r = '';
    $str = mb_str_split($str);
    if ($str != '') {
        foreach ($str as $w) {
            switch ($w) {
                case 'А':
                    $r = $r . 'A';
                    break;
                case 'В':
                    $r = $r . 'V';
                    break;
                case 'С':
                    $r = $r . 'S';
                    break;
                case 'Л':
                    $r = $r . 'L';
                    break;
                case 'О':
                    $r = $r . 'O';
                    break;
                case 'П':
                    $r = $r . 'P';
                    break;
                case 'Т':
                    $r = $r . 'T';
                    break;
                case 'Х':
                    $r = $r . 'H';
                    break;
                case '1':
                    $r = $r . '1';
                    break;
            }
        }

        return $r;
    }


}

function GetPrikazes($prikazes_ids)
{
    $user_id = Yii::$app->user->identity->getId();
    $subQFav = Favorite::find()->where(['user_id' => $user_id]);
    return Prikaz::find()
        ->select([
            'prikaz.*',
            'fav.prikaz_id',
            "COALESCE(pi.symbol, '') as symbol",
            "COALESCE(status.status_name, '') as status_name",
            "COALESCE(status.color, '') as color",
        ])
        ->leftJoin(['pi' => "prikazindex"], 'pi.id=prikaz.index_id')
        ->leftJoin(['status' => "prikaz_action_type"], 'status.id=prikaz.action_id')
        ->leftJoin(['fav' => $subQFav], 'fav.prikaz_id=prikaz.id')
        ->andWhere(['is_del' => false])
        ->andWhere(['IN', 'prikaz.id', $prikazes_ids])
        ->orderBy('id')
        ->all();

}

