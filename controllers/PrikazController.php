<?php


namespace app\controllers;


use app\models\Favorite;
use app\models\Index;
use app\models\ModifiedPrikaz;
use app\models\Prikaz;
use app\models\PrikazCreateForm;
use app\models\PrikazSearch;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;

require_once '../helpers/prikazez.php';

class PrikazController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'download', 'view', 'myfav', 'read', 'favorite', 'delfav'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'del', "get-prikazes", "modified-prikaz", "del-modified"],
                        'roles' => ['admin', 'PrikazCreator', 'MainPrikazCreator'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delall'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($year = null, $month = null, $text = null)
    {

        $searchModel = new PrikazSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionCreate($year = null, $month = null)
    {
        $error = '';
        $model = new PrikazCreateForm();
        $indexes = Index::find()->all();
        $items = ArrayHelper::map($indexes, 'id', 'symbol');

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            if (!$model->validate()) {
                var_dump($model->getErrors());
                die();
            }

            $model->file = UploadedFile::getInstance($model, 'file');
            $index_id = Index::findOne($model->index_id);
            $fullFilePath = GetPrikazName($model->numc, $index_id->symbol, $model->reldate, $model->file->extension);

            CreatePrikazFolder(strtotime($model->reldate));

            if (!is_file(dirname(__DIR__) . '/prikazes/' . $fullFilePath)) {
                $model->file->saveAs(dirname(__DIR__) . '/prikazes/' . $fullFilePath);

                if (is_file(dirname(__DIR__) . '/prikazes/' . $fullFilePath)) {
                    try {
                        $p = CreatePrikaz($model->index_id, $fullFilePath, $model->numc, $model->reldate, $model->text);
                        $this->redirect(['/prikaz/update', "id" => $p->id]);
                    } catch (ErrorException $e) {

                    }
                }
            } else {
                $error = "Такой приказ уже есть!";
            }
        }
        return $this->render('create', compact('model', 'items', 'error', 'year', 'month'));

    }

    public function actionUpdate($id)
    {
        $currentUser = Yii::$app->user;

        $p = getPrikaz($id);





        $indexes = Index::find()->all();
        $items = ArrayHelper::map($indexes, 'id', 'symbol');

        $modifing = $p->getPrikazesModifiedThisPrikaz(STATUS_P_MODIFIED);
        //приказы которые отменили данный приказ
        $canceling = $p->getPrikazesModifiedThisPrikaz(STATUS_P_CANCELED);
        // canceled prikazes by this prikaz
        $canceled = $p->getPrikazesModifiedByThis(STATUS_P_CANCELED);
        // modified prikazes by this prikaz
        $modified = $p->getPrikazesModifiedByThis(STATUS_P_MODIFIED);

        $model = new PrikazCreateForm();

        $ext = $p->getFileExtension();

        $pData = Yii::$app->formatter->asDate($p->reldate, 'php:d-m-Y');
        $y = date('Y', $p->reldate);
        $m = date('m', $p->reldate);
        $d = date('d', $p->reldate);
        $model->reldate = $pData;
        $model->numc = $p->numc;
        $model->index_id = $p->index_id;
        $model->text = $p->text;
        $file = $p->filename;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            if (!$model->validate()) {
                var_dump($model->getErrors());
                die();
            }


            $model->file = UploadedFile::getInstance($model, 'file');
            $index_id = Index::findOne($model->index_id);
            $fullFilePath = GetPrikazName($model->numc, $index_id->symbol, $model->reldate, $ext);
            if ($model->file) {
                CreatePrikazFolder(strtotime($model->reldate));
                if (is_file(dirname(__DIR__) . '/prikazes/' . $fullFilePath)) {
                    unlink(dirname(__DIR__) . '/prikazes/' . $fullFilePath);
                    if (!is_file(dirname(__DIR__) . '/prikazes/' . $fullFilePath)) {
                        $model->file->saveAs(dirname(__DIR__) . '/prikazes/' . $fullFilePath);
                    }
                }
            }
            if ($model->text !== $p->text) {
                $p->text = $model->text;
                if ($p->save()) {
                    addLog($currentUser, 'обновление', $fullFilePath);
                };
            }
            $p->save();
        }


        $indexes = Index::find()->where(['isold' => false])->all();
        $items = ArrayHelper::map($indexes, 'id', 'symbol',);
        $error = '';


        return $this->render('update', compact('model', 'p', 'items', 'error', 'file', 'ext', 'y', 'm', 'items', 'canceled', 'modified', 'canceling', 'modifing'));
    }

    public function actionDownload($filename)
    {
        if (file_exists(dirname(__DIR__) . "/prikazes" . $filename)) {
            \Yii::$app->response->sendFile(dirname(__DIR__) . "/prikazes" . $filename);
        }
    }

    public function actionDel($id)
    {

        $p = Prikaz::findOne($id);
        if ($p->delPrikaz()) {
            return $this->redirect(Yii::$app->request->referrer);
        }


    }


    public function actionView($id)
    {
        $p = getPrikaz($id);

        //приказы которые отменили данный приказ
        $modifing = $p->getPrikazesModifiedThisPrikaz(STATUS_P_MODIFIED);
        //приказы которые отменили данный приказ
        $canceling = $p->getPrikazesModifiedThisPrikaz(STATUS_P_CANCELED);
        // canceled prikazes by this prikaz
        $canceled = $p->getPrikazesModifiedByThis(STATUS_P_CANCELED);
        // modified prikazes by this prikaz
        $modified = $p->getPrikazesModifiedByThis(STATUS_P_MODIFIED);

        $ext = $p->getFileExtension();
        $y = date('Y', $p->reldate);
        $m = date('m', $p->reldate);


        return $this->render('view', compact('p', 'ext', 'modifing', 'canceling', 'canceled', 'modified', 'y', 'm'));
    }

    public function actionRead($id)
    {

        $p = Prikaz::findOne($id);
        //print_r($p);

        $filepath = dirname(__DIR__) . "/prikazes" . $p->filename;
        if (file_exists($filepath)) {
            // Set up PDF headers
            // header('Content-type: application/pdf');
            //header('Content-Disposition: inline; filename="' . $p->filename . '"');
            // header('Content-Transfer-Encoding: binary');
            //header('Content-Length: ' . filesize($filepath));
            //header('Accept-Ranges: bytes');
            header("Content-type: application/pdf");
            $file = readfile($filepath);
            echo $file;
            // Render the file
            //readfile( $filepath);

        } else {
            throw new Exception('файл приказа не найден');
        }
    }

    public function actionFavorite($id)
    {

        if ($id) {
            $p = Prikaz::findOne($id);
            if ($p->addToFavorite()) {
                return json_encode('ok');
            } else {
                return json_encode('error');
            }
        }

    }

    public function actionDelfav($id)
    {

        if ($id) {
            $p = Prikaz::findOne($id);
            if ($p->removeFromFavorite()) {
                return json_encode('ok');
            } else {
                return json_encode('error');
            }
        }

    }

    public function actionMyfav()
    {
        $user_id = Yii::$app->user->identity->getId();
        $prikazes = Prikaz::find()
            ->select([
                'prikaz.*',
                'fav.prikaz_id',
                'fav.user_id',
                "COALESCE(pi.symbol, '') as symbol",
                "COALESCE(status.status_name, '') as status_name",
                "COALESCE(status.color, '') as color",
            ])
            ->leftJoin(['pi' => "prikazindex"], 'pi.id=prikaz.index_id')
            ->leftJoin(['fav' => "favorite"], 'fav.prikaz_id=prikaz.id')
            ->leftJoin(['status' => "prikaz_action_type"], 'status.id=prikaz.action_id')
            ->andWhere(
                ["user_id" => $user_id]
            )
            ->andWhere(
                ["is_del" => false]
            )
            ->orderBy('id')
            ->all();
        return $this->render('myfav', compact('prikazes'));
    }

    public function actionGetPrikazes($index_id, $numc, $current_p_id)
    {
        $p_not_for_search = [];
        $p_not_for_search[] = $current_p_id;
        //ищем приказы модифицированные данным приказом
        $existed_actions = ModifiedPrikaz::find()->where(['prikaz_id' => $current_p_id])->all();
        if (!empty($existed_actions)) {
            foreach ($existed_actions as $m_p) {
                $p_not_for_search[] = $m_p->modified_prikaz_id;
            }


        }


        $prikazes = Prikaz::find()
            ->select([
                'prikaz.text',
                'prikaz.numc',
                'prikaz.id',
                'prikaz.reldate',
                "COALESCE(pi.symbol, '') as symbol",
                "COALESCE(status.status_name, '') as status_name",
                "COALESCE(status.color, '') as color",
            ])
            ->leftJoin(['pi' => "prikazindex"], 'pi.id=prikaz.index_id')
            ->leftJoin(['status' => "prikaz_action_type"], 'status.id=prikaz.action_id')
            ->andWhere(["index_id" => $index_id, 'numc' => $numc, 'is_del' => false])
            ->andWhere(['NOT IN', 'prikaz.id', $p_not_for_search])
            ->orderBy('id')
            ->all();

        $ps = [];
        if (!empty($prikazes)) {
            foreach ($prikazes as $p) {
                $oneP = [
                    'id' => $p->id,
                    'symbol' => $p->symbol,
                    'numc' => $p->numc,
                    'text' => $p->text,
                    'reldate' => Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y'),
                    'color' => $p->color,
                    'status' => $p->status_name
                ];
                $ps[] = $oneP;
            }
            return json_encode($ps);
        } else {
            return json_encode('not');
        }


    }


    public function actionModifiedPrikaz($prikaz_id, $modified_prikaz_id, $action_id)
    {
       $p=Prikaz::findOne($prikaz_id);
        $mod_p=$p->modifiedPrikaz($modified_prikaz_id, $action_id);
       if(!empty($mod_p)){
           $text=$mod_p->text;
           if ($text > 100) {
               $text = substr($text, 0, 99);
           }
           $oneP = [
               'id' => $mod_p->id,
               'symbol' => $mod_p->index->symbol,
               'numc' => $mod_p->numc,
               'text' => $text,
               'reldate' => Yii::$app->formatter->asDate($mod_p->reldate, 'php:d.m.Y'),
               'action_id' => $mod_p->action_id,
               'color' => $mod_p->status->color,
               'status' => $mod_p->status->status_name
           ];

           return json_encode($oneP);
       }else {
           return json_encode('not');
       }


    }

    public function actionDelModified($modified_prikaz_id, $action_id)
    {
        //Приказ может совершить над другим приказом только одно действие - или отменить или изменить
        $refferURL = Yii::$app->request->referrer;
        $parts = parse_url($refferURL);
        $path = $parts['path'];
        if ($path === '/prikaz/update') {
            parse_str($parts['query'], $query);
            $prikaz_id = $query['id'];
           $p=Prikaz::findOne($prikaz_id);

           if($p->cancelModifiing($modified_prikaz_id)){
               return $this->redirect(Yii::$app->request->referrer);
           }else{
               throw new Exception('не удалось отменить изменение');
           }

            }
        }





}