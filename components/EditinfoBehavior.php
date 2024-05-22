<?php
namespace app\components;

use common\models\User;
use Yii;
use yii\base\Behavior;

class EditinfoBehavior extends Behavior
{
    public function editinfo()
    {
        // сохраняем инфу об изменениях
        $username = Yii::$app->user->id;
        $changes = '';
        foreach ($this->owner->dirtyAttributes as $key => $value) {
            $changes = $changes . ($changes == '' ? '' : ', ') . $key . ' => ' . $value;
        }
        if ($this->owner->isNewRecord) {
            $this->owner->created_by = $username;
            $this->owner->created_at = strtotime(date("Y-m-d H:i:s"));
            $this->owner->edit_info = $this->owner->edit_info . ($this->owner->edit_info == '' ? '' : ' <br> ') . "Добавлено (" . date("Y-m-d H:i:s") . "; " . $username . "; " . $changes . ")";
        } else {
            $this->owner->updated_by = $username;
            $this->owner->updated_at = strtotime(date("Y-m-d H:i:s"));
            $this->owner->edit_info = $this->owner->edit_info . ($this->owner->edit_info == '' ? '' : ' <br> ') . "Изменено (" . date("Y-m-d H:i:s") . "; " . $username . "; " . $changes . ")";
        }
    }
}

?>