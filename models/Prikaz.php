<?php


namespace app\models;

use app\components\EditinfoBehavior;
use Yii;
use yii\db\ActiveRecord;

class Prikaz extends ActiveRecord
{
    public $symbol;
    public $prikaz_id;
    public $status_name;
    public $color;
    public $divisions;


    public static function tableName()
    {
        return 'prikaz';
    }

    //
    public function behaviors()
    {
        return [
            EditinfoBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['id', 'numc', 'text', 'filename', 'index_id', 'cteated_at', 'created_by', 'reldate', 'symbol', 'prikaz_id', 'divisions'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        // сохраняем инфу об изменениях
        $this->editinfo();
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function getIndex()
    {
        return $this->hasOne(PrikazIndex::className(), ['id' => 'index_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(ActionType::className(), ['id' => 'action_id']);
    }

    public function del()
    {

    }


    public function getFileExtension()
    {
        $re = '/\.[A-Z,a-z]{3,4}/m';
        if (preg_match($re, $this->filename, $matches)) {
            $ext = strtolower($matches[0]);
            return $ext = str_replace('.', '', $ext);
        }

    }

    public function getNewNameForDeletedPrikaz()
    {
        $ext = $this->getFileExtension();

        $timestamp = $this->reldate;
        $y = date('Y', $timestamp);
        $m = date('m', $timestamp);
        $d = date('d', $timestamp);
        $index = RuStringToEng($this->index->symbol);
        // $dir = '/prikazes/';
        $fullFilePath = '/' . $y . '/' . $y . $m . $d . '-' . 'N' . $this->numc . "-" . $index . "_deleted_" . time() . "." . $ext;
        return $fullFilePath;
    }

    public function delPrikaz()
    {
        $currentUser = Yii::$app->user;
        //получаем новое имя файла приказа при удалении приказа
        $delfilename = $this->getNewNameForDeletedPrikaz();

        $prikazFolder = dirname(__DIR__) . "/prikazes";
        //переименовываем файл приказа
        if (is_file($prikazFolder . $this->filename)) {
            rename($prikazFolder . $this->filename, $prikazFolder . $delfilename);

            if (!is_file(dirname(__DIR__) . "/prikazes" . $this->filename)) {
                $this->is_del = true;
                $this->filename = $delfilename;

                if ($this->save()) {
                    //после удаления приказа необходимо получить все приказы, которые данный приказ изменил
                    $modifiedPrikazesByThis = $this->getPrikazesModifiedByThis();
                    //после удаления приказа необходимо получить все записи,
                    // которые свидетельствют о том что данный приказ изменил другие приказы
                    // или его изменили другие приказы
                    //Нужно удалить все записи
                    $this->delAllModifiedString();
                    //необходимо пересчитать  статусы всех приказов которые изменил this
                    if (!empty($modifiedPrikazesByThis)) {
                        foreach ($modifiedPrikazesByThis as $mp) {
                            $mp->recalculateStatus();
                        }
                    }

                    addLog($currentUser, 'удаление', $delfilename);
                    return true;
                }
            }
        } else {
            print_r("no file");
        }

    }

    //получить все приказы, которые данный приказ изменил
    public function getPrikazesModifiedByThis($status_name = null)
    {
        $query = $modifiedByThisPrikaz = ModifiedPrikaz::find()
            ->select(['modified_prikazes.modified_prikaz_id']);
        if ($status_name !== null) {
            $action = \app\models\ActionType::findOne(['status_name' => $status_name]);
            $modifiedByThisPrikaz = $query->where(['prikaz_id' => $this->id, 'action_id' => $action->id])->all();
        } else {
            $modifiedByThisPrikaz = $query->where(['prikaz_id' => $this->id])->all();
        }

        $modified_ids = [];
        foreach ($modifiedByThisPrikaz as $p) {
            $modified_ids[] = $p->modified_prikaz_id;
        }
        return GetPrikazes($modified_ids);
    }

    public function getPrikazesModifiedThisPrikaz($status_name = null)
    {
        $action = \app\models\ActionType::findOne(['status_name' => $status_name]);
        $prikazesModifiedThisPrikaz = ModifiedPrikaz::find()
            ->select(['modified_prikazes.prikaz_id'])
            ->where(['modified_prikaz_id' => $this->id, 'action_id' => $action->id])
            ->all();
        $modified_ids = [];
        foreach ($prikazesModifiedThisPrikaz as $p) {
            $modified_ids[] = $p->prikaz_id;
        }
        return GetPrikazes($modified_ids);
    }

    public function delAllModifiedString()
    {
        $modifiedStringsByThisPrikaz = ModifiedPrikaz::find()
            ->where(['or',
                ['prikaz_id' => $this->id],
                ['modified_prikaz_id' => $this->id]])->all();
        //Нужно удалить все записи
        if (!empty($modifiedStringsByThisPrikaz)) {
            foreach ($modifiedStringsByThisPrikaz as $string) {
                if (!$string->delete()) {
                    throw new Exception('не удаляется строка');
                }
            }
        }

    }

//пересчитать статус приказа
    public function recalculateStatus()
    {
        //ищем последний приказ, который совершил изменяемое дейтвие над $this
        $mod_p_by_an_p = ModifiedPrikaz::findOne(['modified_prikaz_id' => $this->id]);
        if (!empty($mod_p_by_an_p)) {
            $this->action_id = $mod_p_by_an_p->action_id;
            $this->modified_by_p_id = $mod_p_by_an_p->prikaz_id;
        } else {
            $this->action_id = 3;
            $this->modified_by_p_id = null;
        }
        if($this->save()){
            return true;
        }else{ return false;}
    }

    public function addToFavorite()
    {
        $user_id = Yii::$app->user->identity->getId();
        $fOld = Favorite::findOne(["prikaz_id" => $this->id, 'user_id' => $user_id]);
        if (empty($fOld)) {
            $f = new Favorite();
            $f->prikaz_id = $this->id;
            $f->user_id = $user_id;
            if (!$f->save()) {
                return false;
            }
            return true;
        }
    }


    public function removeFromFavorite()
    {
        $user_id = Yii::$app->user->identity->getId();
        $fOld = Favorite::findOne(["prikaz_id" => $this->id, 'user_id' => $user_id]);
        if (!empty($fOld)) {
            try {
                if ($fOld->delete()) {
                    return true;
                }

            } catch (StaleObjectException $e) {
            } catch (\Throwable $e) {
            }

        }
        return false;
    }


    public function modifiedPrikaz($modified_prikaz_id, $action_id)
    {

        //ищем модификации произведенные данным приказом над модифицируемом приказом
        $existed_actions = ModifiedPrikaz::find()
            ->where([
                'prikaz_id' => $this->id,
                'modified_prikaz_id' => $modified_prikaz_id
            ])
            ->all();

        //ищем был ли отменен приказ другими приказами
        $existed_actions_by_an_p = ModifiedPrikaz::find()
            ->where([
                'modified_prikaz_id' => $modified_prikaz_id,
                'action_id' => '2'])
            ->all();

        if (empty($existed_actions) && empty($existed_actions_by_an_p)) {
            $action = new ModifiedPrikaz();
            $action->prikaz_id = $this->id;
            $action->modified_prikaz_id = $modified_prikaz_id;
            $action->action_id = $action_id;
            if ($action->save()) {
                $mod_p = Prikaz::findOne($modified_prikaz_id);
                $mod_p->action_id = $action_id;
                $mod_p->modified_by_p_id = $this->id;
                if ($mod_p->save()) {
                  return $mod_p;
                }
            }

        }else {
            return null;
        }





    }


    public function cancelModifiing($modified_prikaz_id){
        //приказ над которым было произведено изменение
        $mp=Prikaz::findOne(['id' => $modified_prikaz_id]);
        //Ищем запись о совершаемом действии над модифицируемом приказом ($modified_prikaz_id) в таблице ModifiedPrikaz
        // если запись найдена то удаляем ее - затем ищем последнюю запись о модификации этого приказа и в соответствии с ней проставляем статус приказа
        $modified_prikaz = ModifiedPrikaz::findOne([
            'prikaz_id' => $this->id,
            'modified_prikaz_id' => $modified_prikaz_id]
        );
        if (!empty($modified_prikaz)) {
            if ($modified_prikaz->delete()) {
                //пересчитываем статус приказа
                if($mp->recalculateStatus()){
                    return true;
                }else{ return false;}


            } else {
                return false;
            }

        }

    }

    public function delFile(){
        if (is_file(dirname(__DIR__) . '/prikazes' . $this->filename)) {
        return unlink(dirname(__DIR__) . '/prikazes' . $this->filename);
        }
    }



}