<?php


namespace app\controllers;
require_once '../helpers/prikazez.php';

use app\models\Index;
use app\models\Prikaz;
use app\models\PrikazCopy;
use XBase\TableReader;

use Yii;
use yii\db\Exception;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class DbfController extends Controller
{

    public function actionIndex()
    {

        if (isset($_GET)) {
            $dirToPDF = $dir = dirname(__DIR__) . '/dbf/prikaz_rektor.dbf';
            $table = new TableReader($dirToPDF, [
                'encoding' => 'cp1251'
            ]);

            $indexes = [];
            $vsego = 0;
            $s = 0;
            $ls = 0;
            $l = 0;
            $bn = 0;
            $bDn = 0;
            $pusto = 0;
            $ahvs = 0;
            $ahv = 0;
            $avs = 0;
            $av = 0;
            $kpk = 0;
            $st = 0;
            $proekt = 0;
            $lasp = 0;
            $def = 0;


            $prikazes = [];
            while ($record = $table->nextRecord()) {

                $numc = $record->get('nom_pr');
                if ($numc == '0') {
                    $numc = '';
                }

                $text = $record->get('soderg');
                $reldata = $record->get('data_pr');
                //$id=$record->get('id');
                $reldata = str_replace(" ", "", $reldata);
                $ext = '';
                $file_name = $record->get('name_file');
                $old_file_name = $file_name;
                if ($file_name) {
                    $file_name = str_replace("\\\\GSE264-100\\D_BASE\\PRIKAZY", "", $file_name);
                    $file_name = str_replace("W:\D_BASE\PRIKAZY", "", $file_name);
                    $file_name = str_replace("\\", "/", $file_name);
                    $re = '/\.[A-Z,a-z]{3,4}/m';
                    if (preg_match($re, $file_name, $matches)) {
                        $ext = strtolower($matches[0]);
                        $ext = str_replace('.', '', $ext);
                    }

                }


                $indx = trim(mb_strtoupper($record->get('nom_pr1')));
                $indx = str_replace(" ", "", $indx);
                $indx = str_replace("\"", "", $indx);
                $indx = str_replace("-", "", $indx);

                if (!in_array($indx, $indexes)) {
                    $indexes[] = $indx;
                }
//обрабатываем индекс
                switch ($indx) {
                    case 'С':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case 'C':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case 'С.':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case 'СРАСПОРЕ':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case '1/С':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case '/1С':
                        $s = $s + 1;
                        $indx = 'С';
                        break;
                    case 'ЛС':
                        $ls = $ls + 1;
                        $indx = 'ЛС';
                        break;
                    case 'ЛC':
                        $ls = $ls + 1;
                        $indx = 'ЛС';
                        break;
                    case 'ОПТC':
                        $opts = +1;
                        $indx = 'ОПТС';
                        break;
                    case 'Л':
                        $l = $l + 1;
                        $indx = 'Л';
                        break;
                    case 'ЛАСП':
                        $lasp = $lasp + 1;
                        $indx = 'ЛАСП';
                        break;
                    case '1Л':
                        $l = $l + 1;
                        $indx = 'Л';
                        break;
                    case 'БН':
                        $bn = $bn + 1;
                        $indx = '';

                        break;
                    case 'Б/Н':
                        $bDn = $bDn + 1;
                        $indx = '';
                        break;
                    case '':
                        $pusto = $pusto + 1;
                        $indx = '';
                        break;
                    case 'АХВС':
                        $ahvs = $ahvs + 1;
                        $indx = 'АХВС';
                        break;
                    case 'AXBС':
                        $ahvs = $ahvs + 1;
                        $indx = 'АХВС';
                        break;
                    case 'АХВ':
                        $ahv = $ahv + 1;
                        $indx = 'АХВ';
                        break;
                    case 'АВС':
                        $avs = $avs + 1;
                        $indx = 'АВС';
                        break;
                    case 'АСВ':
                        $avs = $avs + 1;
                        $indx = 'АВС';
                        break;
                    case 'АБС':
                        $avs = $avs + 1;
                        $indx = 'АВС';

                        break;
                    case '1/АВС':
                        $avs = $avs + 1;
                        $indx = 'АВС';
                        break;
                    case 'АВ':
                        $av = $av + 1;
                        $indx = 'АВ';
                        break;
                    case 'КПК':
                        $kpk = $kpk + 1;
                        $indx = 'КПК';
                        break;
                    case 'СТ':
                        $st = $st + 1;
                        $indx = 'СТ';
                        break;
                    case 'ПРОЕКТ':
                        $proekt = $proekt + 1;
                        $indx = 'ПРОЕКТ';
                        break;
                    case 'ПРОЕКТ2':
                        $indx = 'ПРОЕКТ';
                        $proekt = $proekt + 1;
                        break;
                    case '123У':
                        $pusto = $pusto + 1;
                        $indx = '';

                        break;
                    case 'Р':
                        $pusto = $pusto + 1;
                        $indx = '';
                        break;
                    default:
                        $def = $def + 1;
                        break;
                }


                $vsego = $vsego + 1;
                if ($reldata != '' && $file_name != null) {
                    $full_name = dirname(__DIR__) . '/oldprikazy/' . $file_name;
                    if (is_file($full_name)) {
                        $pr = new PrikazCopy();
                        $pr->nums = $indx;
                        $pr->numc = $numc;
                        // $pr->id= $id;
                        if ($pr->nums != '') {

                            $index = Index::findOne(['symbol' => $pr->nums]);
                            if (!$index) {

                                $pr->index_id = 13;
                            } else {
                                $pr->index_id = $index->id;
                            }

                        } else {
                            $pr->index_id = 13;
                        }

                        if ($reldata == "12010830") {
                            $reldata = "20170830";
                        }
                        if ($reldata == "02091205") {
                            $reldata = "20191205";
                        }
                        if ($reldata == "02091218") {
                            $reldata = "20191218";
                        }
                        if ($reldata == "02091219") {
                            $reldata = "20191219";
                        }
                        if ($reldata == "02210624") {
                            $reldata = "20210624";
                        }


                        $pr->reldate = $reldata;
                        $pr->text = $text;
                        $pr->ext = $ext;
                        $pr->oldfilename = $old_file_name;
                        $pr->filename = $file_name;
                        $prikazes[] = $pr;
                    }


//                    \Yii::debug($full_name,'---------------------------');

                    //$pr->filename = $file_name;

                }
            }

            // $data = json_encode($prikazes);

//            foreach ($prikazes as $newp){
//
//                //
//                $newFileName = GetPrikazName($newp->numc, $newp->nums, $newp->reldate, $newp->ext);
//
//                print_r($newFileName . "<br>" . $newp->filename . "<br>" . $newp->reldate . "<br>" . $newp->oldfilename . "<br>",);
//
//                CreatePrikaz($newp->index_id, $newFileName,$newp->numc, $newp->reldate, $newp->text, $newp->filename);
//
//            }


        }

        return $this->render('index', compact('prikazes'));
    }

    public function actionCopy()
    {

        return $this->render('copy');

    }

    public function actionOld()
    {
        $ps = [];
        $prikazes = Prikaz::find()->select(['id'])->column();
        foreach ($prikazes as $key => $val) {
            $ps[] = $val;
        }
        //print_r($ps);
        return json_encode($ps);

    }


    public function actionCreate($id)
    {
//        if (isset($_GET)) {
////
////            foreach ($_GET as $key => $item) {
////                if ($key != '_') {
////                    $data = $key;
////                    return json_decode($data);
////                }
////
////            }
////
////        }

        $request = Yii::$app->request;
        if ($request->isAjax) {
            if ($id) {

                $p = Prikaz::findOne($id);

                $newPath = dirname(__DIR__) . "/prikazes" . $p->filename;
                $oldPath = dirname(__DIR__) . "/oldprikazy" . $p->oldfilename;
                CreatePrikazFolder($p->reldate);
                if (is_file($oldPath)) {

                    if (!is_file($newPath)) {
                        copy($oldPath, $newPath);
                        return json_encode("yes ".$oldPath);
                    }else{
                        return json_encode("yes ");
                    }
                }else{
                    return json_encode("no ".$oldPath);
                }



            }

        }


    }


}