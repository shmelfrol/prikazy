<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>


<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'username', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Логин')?>
<?= $form->field($model, 'password', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Пароль')?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>