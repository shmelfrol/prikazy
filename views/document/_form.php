<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Document $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'numc')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'filename')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'index_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'reldate')->textInput() ?>

    <?= $form->field($model, 'oldfilename')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'edit_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_del')->checkbox() ?>

    <?= $form->field($model, 'action_id')->textInput() ?>

    <?= $form->field($model, 'modified_by_p_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
