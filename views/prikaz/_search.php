<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PrikazSearch $model */
/** @var yii\widgets\ActiveForm $form */
/* @var $years array */
/* @var $months array */
?>

<div class="document-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
//        'action' => [
//            \yii\helpers\Url::current(), ['year' => $model->year, 'month'=>$model->month],
//        ]
    ]); ?>

    <?= $form->field($model, 'text', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Название')?>
    <?php echo $form->field($model, 'year')->dropDownList($model->years)->label('Год'); ?>
    <?php echo $form->field($model, 'month')->dropDownList($model->months)->label("Месяц"); ?>

    <?php //$form->field($model, 'id') ?>

    <?php // $form->field($model, 'numc') ?>

    <?php // $form->field($model, 'text') ?>

    <?php // $form->field($model, 'filename') ?>

    <?php // $form->field($model, 'index_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'reldate') ?>

    <?php // echo $form->field($model, 'oldfilename') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'edit_info') ?>

    <?php // echo $form->field($model, 'is_del')->checkbox() ?>

    <?php // echo $form->field($model, 'action_id') ?>

    <?php // echo $form->field($model, 'modified_by_p_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
