<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php if($message): ?>
    <div class="alert alert-danger"><?php echo $message ?>  </div>
<?php endif; ?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin/users')]) ?>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'username', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Логин')?>
<?= $form->field($model, 'roles')->checkboxList($roles)->label("Роли") ?>
<?= $form->field($model, 'password')->passwordInput()->label('Пароль'); ?>
<?= $form->field($model, 'repassword')->passwordInput()->label('Повторите пароль'); ?>

<div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>



