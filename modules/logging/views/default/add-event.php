<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php echo \app\components\BackButtonWidget::widget([]) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Название события') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>