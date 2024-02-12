<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php if($message): ?>
    <div class="alert alert-danger"><?php echo $message ?>  </div>
<?php endif; ?>

    <div>
        <a href="<?php echo Url::toRoute('/admin/users'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>
<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'username', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Логин')?>
<?= $form->field($model, 'roles')->checkboxList($roles)->label("Роли") ?>
<?= $form->field($model, 'password')->passwordInput()->label('Пароль'); ?>
<?= $form->field($model, 'repassword')->passwordInput()->label('Повторите пароль'); ?>

<div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'phone', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->widget(\yii\widgets\MaskedInput::className(),['mask'=>'+7 (999) 99-999-99'])->label('Введите номер телефона')?>
<div class="form-group">
    <?= Html::submitButton('Добавить телефон', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end(); ?>
<?php foreach ($userPhones as $phone): ?>
    <p><?php echo $phone->phone; ?> <a style="text-decoration: none" href="<?php echo Url::toRoute(['del-phone', 'id'=> $phone->id]); ?>">&#10060;</a></p>

<?php endforeach; ?>

