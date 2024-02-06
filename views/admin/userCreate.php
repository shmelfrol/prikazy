<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

    <div>
        <a href="<?php echo Url::toRoute('/admin/users'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>
<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'username', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Логин')?>
<?= $form->field($model, 'password', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Пароль')?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>